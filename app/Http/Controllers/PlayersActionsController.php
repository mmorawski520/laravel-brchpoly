<?php
namespace App\Http\Controllers;
use App\Models\Board;
use App\Models\User;
use App\Models\Player;
use App\Models\PlayerActions;
use App\Models\Pages;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\EditActionValidation;
class PlayersActionsController extends Controller
{
    public function index($id, $board_id,$task)
    {
         $players_in_board = Player::where("players.board_id", "=", $board_id)->get();
     /*    $actions=PlayerActions::first()->tasks($id,$board_id,$task);
         return view('players_actions.index', ["actions" => $actions, "players_in_board" => $players_in_board]);
     */
          if ($task == "current") {
            $boards = DB::select('select * from boards where user_id = ?', [$id, ]);
            $actions = Player::join("player_actions", "players.id", "=", "player_actions.player_id")->where("players.board_id", "=", $board_id)->where("player_actions.player_id", "=", $id)->orderBy("player_actions.created_at", "DESC")->paginate(5);
        }
        if ($task == "every") {
            $boards = DB::select('select * from boards where user_id = ?', [$id, ]);
            $actions = Player::join("player_actions", "players.id", "=", "player_actions.player_id")->where("players.board_id", "=", $board_id)->orderBy("player_actions.created_at", "DESC")->paginate(5);
        }
        return view('players_actions.index', ["actions" => $actions, "players_in_board" => $players_in_board]);
    }
    public function edit($id){
        $actionTypes=array("send_to_everyone"=>"send_to_everyone","salary"=>"salary","receive"=>"receive","receive_from_everyone"=>"receive_from_everyone","send_to_bank"=>"send_to_bank","send_to_another_player"=>"send_to_another_player");     
        $action=PlayerActions::where("id","=",$id)->first();
        $board=Player::where("id","=",$action->player_id)->first();
        $players_in_board = Player::where("players.board_id", "=",$board->board_id)->get();
        return view('players_actions.edit',["action"=>$action,"players_in_board"=>$players_in_board,"actionTypes"=>$actionTypes,"id"=>$id]);    }
    public function updateAction(EditActionValidation $EditActionValidation,$id)
    {
        //$id=$EditActionValidation->id;
         $amount=$EditActionValidation->input("ReceiveValue");
        $change=$EditActionValidation->input("actionSelect");
     // return $id;
        return PlayerActions::first()->updateAction($EditActionValidation->id,$EditActionValidation);
    }
    public function destroy($id)
    {
       return PlayerActions::first()->deleteAction($id); 
    }
}

