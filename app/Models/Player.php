<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\PlayersStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Board;
use App\Models\User;
use App\Models\Player;
use App\Models\PlayerActions;

class Player extends Model
{
    use HasFactory;
    protected $table="players";
    protected $primaryKey="id";
    protected $fillable=['board_id','nickname','players_balance','bankrupt'];
    public function Players(){
        return $this->belongsTo(Boards::class);
    }
    public function getData(request $request,$id){
        return array("playerId"=>$playerId,"playerName"=>$playerName,"board"=>$board,"boardId"=>$boardId,"currentPlayer"=>$currentPlayer,"betterPlayer"=>$betterPlayer,"betterPlayerId"=>$betterPlayerId,"receivedValue"=>$receivedValue,"decreasedBalance"=>$decreasedBalance,"increasedBalance"=>$increasedBalance,"players"=>$players);
    }
    public function sendToAnotherPlayerStore(request $request, $id){
         
        $playerId = $id;
        $playerName = $request->input("toPlayer");
        $board = DB::table('players')->where('id', '=', $playerId)->first();
        $boardId = $board->board_id;
        $currentPlayer = DB::table('players')->where('board_id', '=', $boardId)->where('id', '=', $playerId)->first();
        $betterPlayer = DB::table('players')->where('board_id', '=', $boardId)->where('nickname', '=', $playerName)->first();
        $betterPlayerId = $betterPlayer->id;
        $receivedValue = $request->input('ReceiveValue');
        $decreasedBalance = $currentPlayer->players_balance - $receivedValue;
        $increasedBalance = $betterPlayer->players_balance + $receivedValue;
        $players = DB::table('players')->where('id', '!=', $playerId)->where('board_id', '=', $boardId)->get();
        if ($players->contains('nickname', $playerName))
        {
            $validate = $request->validate(["ReceiveValue" => "required|min:1|gt:0|max:$currentPlayer->players_balance", ]);
            if ($validate)
            {
                PlayerActions::create(["player_id" => $playerId, 'action_type' => 'send_to_another_player', 'enemy_id' => $betterPlayerId, 'amount' => $receivedValue]);
                Player::where('id', '=', $playerId)->update(['players_balance' => $decreasedBalance]);
                Player::where('id', '=', $betterPlayerId)->update(['players_balance' => $increasedBalance]);
                return redirect()->route('currentBoard', ['id' => $boardId]);
            }
            else
            {
                return route('sendToAnotherPlayer', ['id' => $playerId, 'board_id' => $boardId]);
            }
        }
        else
        {
            return redirect("/home");
        }
    }
    public function salary(request $request){
        $playerId = $request->id;
        $board = DB::table('players')
            ->join('boards', 'players.board_id', '=', 'boards.id')
            ->where('players.id', '=', $playerId)
            ->first();
        $salary = $board->salary;
        $currentPlayer = Player::where('id', '=', $playerId)->first();
        $currentBalance = $currentPlayer->players_balance;
        $newBalance = $currentBalance + $salary;
        
        Player::where('id', '=', $playerId)->update(['players_balance' => $newBalance]);
        PlayerActions::create(["player_id" => $playerId, 'action_type' => 'salary', 'enemy_id' => 0, 'amount' => $salary]);

        return redirect()->route('currentBoard', ['id' => $board->board_id]);
    }
    public function receiveStore(request $request){

        $receivedValue = $request->input('ReceiveValue');
        $playerId = $request->id;
        $board = DB::table('players')->where('id', '=', $playerId)->first();
        $validate = $request->validate(["ReceiveValue" => "required|min:1|gt:0",

        ]);
        if (!$validate)
        {
            return route('receive', ['id' => $playerId, 'board_id' => $boardId]);
        }
        else
        {
             
            $currentPlayer = Player::where('id', '=', $playerId)->first();
            $currentBalance = $currentPlayer->players_balance;
            $newBalance = $currentBalance + $receivedValue;

            PlayerActions::create(["player_id" => $playerId, 'action_type' => 'receive', 'enemy_id' => 0, 'amount' => $receivedValue]);
            Player::where('id', '=', $playerId)->update(['players_balance' => $newBalance]);

            return redirect()->route('currentBoard', ['id' => $board->board_id]);
        }
    }
    public function sendBankStore(request $request)
    {
        $receivedValue = $request->input('ReceiveValue');
        $playerId = $request->id;
        $board = DB::table('players')->where('id', '=', $playerId)->first();
        $currentPlayer = Player::where('id', '=', $playerId)->first();
        $currentBalance = $currentPlayer->players_balance;
        $validate = $request->validate(["ReceiveValue" => "required|min:1|gt:0|max:$currentBalance",

        ]);
        if (!$validate)
        {
            return route('sendBank', ['id' => $playerId, 'board_id' => $boardId]);
        }
        else
        {
            // return route('currentBoard',['id'=>$boardId]);
            //return $boardId->board_id;
            $newBalance = $currentBalance - $receivedValue;
            Player::where('id', '=', $playerId)->update(['players_balance' => $newBalance]);
            PlayerActions::create(["player_id" => $playerId, 'action_type' => 'send_to_bank', 'enemy_id' => 0, 'amount' => $receivedValue]);
            return redirect()->route('currentBoard', ['id' => $board->board_id]);

        }
    }
    public function sendToEveryoneStore(request $request)
    {
        $receivedValue = $request->input('ReceiveValue');
        $playerId = $request->id;
        $board = DB::table('players')->where('id', '=', $playerId)->first();
        $currentPlayer = Player::where('id', '=', $playerId)->first();
        $currentBalance = $currentPlayer->players_balance;

        $validate = $request->validate(["ReceiveValue" => "required|min:1|gt:0|max:$currentBalance",

        ]);
        if (!$validate)
        {
            return route('sendToEveryone', ['id' => $playerId, 'board_id' => $boardId]);
        }
        else
        {
            // return route('currentBoard',['id'=>$boardId]);
            //return $boardId->board_id;
            $newBalance = $currentBalance - $receivedValue * Player::where('id', '!=', $playerId)->where('board_id', '=', $board->board_id)
                ->count();

            Player::where('id', '=', $playerId)->update(['players_balance' => $newBalance]);
            Player::where('id', '!=', $playerId)->where('board_id', '=', $board->board_id)
                ->increment('players_balance', $receivedValue);
            PlayerActions::create(["player_id" => $playerId, 'action_type' => 'send_to_everyone', 'enemy_id' => 0, 'amount' => $receivedValue]);
            return redirect()->route('currentBoard', ['id' => $board->board_id]);

        }
    }
    public function receiveFromAllStore(request $request){
        
        $receivedValue = $request->input('ReceiveValue');
        $playerId = $request->id;
        $board = DB::table('players')->where('id', '=', $playerId)->first();
        $currentPlayer = Player::where('id', '=', $playerId)->first();
        $currentBalance = $currentPlayer->players_balance;
        $validate = $request->validate(["ReceiveValue" => "required|min:1|gt:0|max:$currentBalance",

        ]);
        if (!$validate)
        {
            return route('receiveFromAll', ['id' => $playerId, 'board_id' => $boardId]);
        }
        else
        {
            // return route('currentBoard',['id'=>$boardId]);
            //return $boardId->board_id;
            $newBalance = $currentBalance + $receivedValue * Player::where('id', '!=', $playerId)->where('board_id', '=', $board->board_id)
                ->count();

            Player::where('id', '=', $playerId)->update(['players_balance' => $newBalance]);
            Player::where('id', '!=', $playerId)
                ->where('board_id', '=', $board->board_id)
                ->decrement('players_balance', $receivedValue);
            PlayerActions::create(["player_id" => $playerId, 'action_type' => 'receive_from_everyone', 'enemy_id' => 0, 'amount' => $receivedValue]);
            return redirect()->route('currentBoard', ['id' => $board->board_id]);

        }
    }
    public function store(PlayersStoreRequest $request)
    {
        $AmountOfPlayers = $request->input('AmountOfPlayers');
        $BoardId = $request->input('BoardId');
        $StartingBalance = $request->input('StartingBalance');
        $IfBoardHasPlayers = DB::table('players')->where('board_id', $BoardId)->count();

        if ($IfBoardHasPlayers == 0)
        {
            $validate = $request->validated();
        }
        else
        {
            return redirect('/home');
        }
        if (!$validate)
        {
            return redirect('boards/createPlayers', ['AmountOfPlayers' => $AmountOfPlayers]);
        }
        else
        {
            for ($i = 0;$i < $AmountOfPlayers;$i++)
            {
                $j = $i;
                $j++;
                $player = Player::create(["nickname" => $request->input("PlayerName" . $j) , "board_id" => $BoardId, "players_balance" => $StartingBalance]);
                $player->save();
                unset($player);
            }
            return redirect()->route('currentBoard', ['id' => $BoardId]);
        }
    }
}
