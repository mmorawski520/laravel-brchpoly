<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BoardStoreRequest;
use App\Http\Requests\PlayersStoreRequest;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Board;
use App\Models\PlayerActions;
use App\Models\User;

class Board extends Model
{
    use HasFactory;

    protected $table = "boards";
    protected $primaryKey = "id";
    protected $fillable = ['board_name', 'user_id', 'amount_of_players', 'salary', 'starting_balance'];

    public static function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function redirectToPlayerCreator($amount_of_players,$id,$starting_balance){
        return redirect()->route('players.create', ['AmountOfPlayers' => $amount_of_players,
            'BoardId' => $id,
            'StartingBalance' => $starting_balance]);
    }
    public static function getYourBoard($user_id,$id){
        return DB::table('users')->join('boards', 'users.id', '=', 'boards.user_id')
            ->join('players', 'boards.id', '=', 'players.board_id')
            ->where('users.id', '=', $user_id)->where('players.board_id', '=', $id)->count();
    }
    public static function getCurrentBoard($id)
    {
        //checks if board is own of the user
        $board = Board::where("id", "=", $id)->first();
        $players = Player::where("board_id", "=", $id)->get();
        $user_id = auth()->user()->id;
        $IsItYoursBoard = self::getYourBoard($user_id,$id);
        $IfBoardHavePlayers = DB::table('players')->where("board_id", "=", $id)->count();

        if ($IsItYoursBoard != 0) {
            if ($IfBoardHavePlayers != 0) {
                return view('boards.currentBoard', ["board" => $board, "players" => $players]);
            } else {
               return self::redirectToPlayerCreator($board->amount_of_players,$board->id,$board->starting_balance);
            }
        } else {
            if ($IfBoardHavePlayers == 0) {
                return self::redirectToPlayerCreator($board->amount_of_players,$board->id,$board->starting_balance);
            } else {
                return redirect('/home');
            }

        }
    }

    public static function updateBoard(request $request)
    {
        if ($request->boardName) {
            Board::where("id", "=", $request->id)->update(["board_name" => $request->boardName]);
        }
        if ($request->salary) {
            Board::where("id", "=", $request->id)->update(["salary" => $request->salary]);
        }
        if ($request->startingBalance) {
            Board::where("id", "=", $request->id)->update(["starting_balance" => $request->startingBalance]);
        }
        return redirect("/boards");

    }

    public static function reset($id)
    {
        $BoardAmount = Board::select("starting_balance")->where("boards.id", "=", $id)->first();
        PlayerActions::join("players", "player_actions.player_id", "=", "players.id")
            ->where("board_id", "=", $id)
            ->delete();
        Player::where("board_id", "=", $id)
            ->update(["players_balance" => $BoardAmount->starting_balance]);
        return redirect()->back();
    }

    public static function storeBoard(request $request)
    {
        $AmountOfPlayers = $request->input("AmountOfPlayers");
        $StartingBalance = $request->input("StartingBalance");
        $userId = auth()->user()->id;
        $validate = $request->validated();

        $board = Board::create(["board_name" => $request->input("BoardName"),
            "amount_of_players" => $request->input("AmountOfPlayers"),
            "user_id" => $userId,
            "salary" => $request->input("salary"),
            "starting_balance" => $request->input("StartingBalance")]);

        $board->save();
        $BoardId = $board->id;

        if (!$validate) {
            return redirect('boards/create')->with("AmountOfPlayers", $AmountOfPlayers);
        } else {
            return redirect()->route('players.create', ['AmountOfPlayers' => $AmountOfPlayers,
                'BoardId' => $BoardId,
                'StartingBalance' => $StartingBalance]);
        }
    }
}
