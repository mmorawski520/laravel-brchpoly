<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Board;
use App\Models\User;
use App\Models\Player;
use App\Models\PlayerActions;
use App\Models\Pages;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\EditActionRequest;
class PlayerActions extends Model {
    use HasFactory;
    protected $table = "player_actions";
    protected $primaryKey = "id";
    protected $fillable = ["player_id", "action_type", "enemy_id", "amount"];
    public function PlayersActions() {
        return $this->belongsTo(Player::class);
    }
    public function tasks($id, $board_id, $task) {
     /*   if ($task == "current") {
            $boards = DB::select('select * from boards where user_id = ?', [$id, ]);
            $actions = Player::join("player_actions", "players.id", "=", "player_actions.player_id")->where("players.board_id", "=", $board_id)->where("player_actions.player_id", "=", $id)->orderBy("player_actions.created_at", "DESC")->paginate(5);
        }
        if ($task == "every") {
            $boards = DB::select('select * from boards where user_id = ?', [$id, ]);
            $actions = Player::join("player_actions", "players.id", "=", "player_actions.player_id")->where("players.board_id", "=", $board_id)->orderBy("player_actions.created_at", "DESC")->paginate(5);
        }*
        return $actions;*/}
    //Undo functions ******************************************************************
    public function receiveOrSalaryUndo($amount, $playersId) {
        Player::where('id', '=', $playersId)->decrement('players_balance', $amount);
    }
    public function sendToBankUndo($amount, $playerId) {
        Player::where('id', '=', $playerId)->increment('players_balance', $amount);
    }
    public function sendAnotherPlayerUndo($amount, $playersId, $enemyId) {
        Player::where('id','=',$playersId)->increment('players_balance',$amount);
        Player::where('id','=',$enemyId)->decrement('players_balance',$amount);
    }
    public function sendToEveryoneUndo($amount, $playersId, $boardId) {
        $amountOfPlayers = Player::where("board_id", "=", $boardId)->count() - 1;
        Player::where("id", '=', $playersId)->increment('players_balance', $amount * $amountOfPlayers);
        Player::where("id", '!=', $playersId)->where('board_id', '=', $boardId)->decrement('players_balance', $amount);
        return $amountOfPlayers;
    }
    public function receiveFromEveryoneUndo($amount, $playersId, $boardId) {
        $amountOfPlayers = Player::where("board_id", "=", $boardId)->count() - 1;
        Player::where("id", '=', $playersId)->decrement('players_balance', $amount * $amountOfPlayers);
        Player::where("id", '!=', $playersId)->where('board_id', '=', $boardId)->increment('players_balance', $amount);
        return $amountOfPlayers;
    }
    //Deleting individual actions ************************************************************************************
    public function deleteReceiveOrSalary($taskId) {
        
        PlayerActions::where("id", '=', $taskId)->delete();
    }
    public function deleteSendToBank($taskId) {
        
        PlayerActions::where("id", '=', $taskId)->delete();
    }
    public function deleteSendToAnotherPlayer($taskId) {
         
        PlayerActions::where("id", '=', $taskId)->delete();
    }
    public function deleteSendToEveryone($taskId) {
        
        PlayerActions::where("id", '=', $taskId)->delete();
    }
    public function deleteReceiveFromEveryone($taskId) {
        
        PlayerActions::where("id", '=', $taskId)->delete();
    }
    //Main deleteting function *****************************************************************************************
    public function deleteAction($id) {
        $action = PlayerActions::where("id", "=", $id)->get();
        $action_type = $action[0]->action_type;
        $playerId = $action[0]->player_id;
        $enemyId = $action[0]->enemy_id;
        $amount = $action[0]->amount;
        $amount = abs($amount);
        $playerIdCurrent = Player::where("id", "=", $playerId)->first();
        $boardId = $playerIdCurrent->board_id;
        $playerIdCurrentBalance = $playerIdCurrent->players_balance;
        
          $this->correctUndo($action[0],$amount,$id,$playerIdCurrent);
        if ($action_type == "receive" || $action_type == "salary") {
            $this->deleteReceiveOrSalary($id);
        } elseif ($action_type == "send_to_bank") {
            $this->deleteSendToBank($id);
        } elseif ($action_type == "send_to_another_player") {
            $this->deleteSendToAnotherPlayer($id);
        } elseif ($action_type == "send_to_everyone") {
            $this->deleteSendToEveryone($id);
        } elseif ($action_type == "receive_from_everyone") {
            $this->deleteReceiveFromEveryone($id);
        }
        return redirect()->route("currentBoard", ["id" => $playerIdCurrent->board_id]);
    }
    //choose correct undo action
        public function correctUndo($action,$amount,$id,$player){
            if ($action->action_type == "receive" || $action->action_type == "salary") {
             $this->receiveOrSalaryUndo($action->amount, $action->player_id);
        } elseif ($action->action_type == "send_to_bank") {
             $this->sendToBankUndo($action->amount, $action->player_id);
        } elseif ($action->action_type == "send_to_another_player") {
               $this->sendAnotherPlayerUndo($amount, $action->player_id, $action->enemy_id);
        } elseif ($action->action_type == "send_to_everyone") {
           $this->sendToEveryoneUndo($amount, $action->player_id,$player->board_id);
        } elseif ($action->action_type == "receive_from_everyone") {
              $this->receiveFromEveryoneUndo($amount, $action->player_id,$player->board_id);
        }
        }
    

    //Choose correct updating function
    public function correctUpdate($action, $amount, $id, $player,$change) {
        if ($change == "receive") {
            
            return $this->receiveUpdate($action, $amount, $id);
            

        }
        if ($change == "send_to_bank") {
           
            return $this->sendToBankUpdate($action, $amount, $id);       
        }
        if ($change == "send_to_everyone") {
             
            return $this->sendToEveryoneUpdate($action, $amount, $id, $player);
        }
        if ($change == "receive_from_everyone") {
          
            return $this->receiveFromEveryoneUpdate($action, $amount, $id, $player);
        }
        if ($action->action_type == "send_to_another_player") {
     
            return $this->sendToAnotherPlayerUpdate($action, $amount, $id, $player);
        }
    }
    //updating functions
    public function receiveUpdate($action, $newAmount, $id) {
       // $action = PlayerActions::where("id", "=", $id)->first();
         
        $player = Player::where("id", "=", $action->player_id)->increment("players_balance", $newAmount);
        PlayerActions::where("id", "=", $id)->update(["amount" => abs($newAmount),"action_type"=>"receive"]);
        return;
    }
    public function sendToBankUpdate($action, $newAmount, $id) {
        //$action = PlayerActions::where("id", "=", $id)->first();
         
        $player = Player::where("id", "=", $action->player_id)->decrement("players_balance", $newAmount);
        PlayerActions::where("id", "=", $id)->update(["amount" => abs($newAmount),"action_type"=>"send_to_bank" ]);
        return;
    }
    public function sendToEveryoneUpdate($action, $newAmount, $id, $player) {
         $amountOfPlayers = Player::where("board_id", "=", $player->board_id)->count() - 1;
        Player::where("id", '=', $action->player_id)->where('board_id', '=', $player->board_id)->decrement('players_balance', $newAmount * $amountOfPlayers);
        Player::where("id", '!=', $action->player_id)->where('board_id', '=', $player->board_id)->increment('players_balance', $newAmount);
        PlayerActions::where("id", '=', $id)->update(['amount' => $newAmount,"action_type"=>"send_to_everyone"]);
    }
    public function sendToAnotherPlayerUpdate($action, $newAmount, $id, $player) {
        $enemyCurrentBalance = Player::where("id", "=", $action->enemy_id)->first();
         
        Player::where('id', '=', $action->player_id)->decrement('players_balance', $newAmount);
        Player::where('id', '=', $enemyCurrentBalance->id)->increment('players_balance', $newAmount);
         
        PlayerActions::where("id", '=', $id)->update(['amount' => $newAmount,"action_type"=>"send_to_another_player","enemy_id"=>$action->enemy_id]);
    }
    public function receiveFromEveryoneUpdate($action, $newAmount, $id, $player) {
         $amountOfPlayers = Player::where("board_id", "=", $player->board_id)->count() - 1;
        Player::where("id", '=', $action->player_id)->where('board_id', '=', $player->board_id)->increment('players_balance', $newAmount * $amountOfPlayers);
        Player::where("id", '!=', $action->player_id)->where('board_id', '=', $player->board_id)->decrement('players_balance', $newAmount);
        PlayerActions::where("id", '=', $id)->update(['amount' => $newAmount,"action_type"=>"receive_from_everyone"]);
    }
    //Main Updating function
    public function updateAction($id, request $request) {
        $action = PlayerActions::where("id", "=", $id)->first();
        $amount = $request->input("ReceiveValue");
        $change = $request->input("actionSelect");
        if(!is_numeric($amount)){
            $change=$action->amount;
        } 
               $player = Player::where("id", "=", $action->player_id)->first();
        $boardId = $player->board_id;
            
            $this->correctUndo($action,$amount,$id,$player);
            $this->correctUpdate($action, $amount, $id, $player,$change);
        
        // return $action->action_type;
        return redirect()->route("currentBoard", ["id" => $boardId]);
    }
}
