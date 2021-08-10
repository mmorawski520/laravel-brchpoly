<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PlayersStoreRequest;
use App\Models\Board;
use App\Models\User;
use App\Models\Player;
use App\Models\PlayerActions;

class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function receive(Request $request)
    {
        return view('boards.receive', [
            "board_id" => $request->board_id,
            "id" => $request->id,
        ]);
    }

    public function salary(Request $request)
    {
        return Player::first()->salary($request);
    }

    public function send(Request $request)
    {
        return view('boards.send', [
            "board_id" => $request->board_id,
            "id" => $request->id,
        ]);
    }

    public function sendBank(Request $request)
    {
        return view('boards.sendBank', [
            "board_id" => $request->board_id,
            "id" => $request->id,
        ]);
    }

    public function sendToEveryone(Request $request)
    {
        return view('boards.sendToEveryone', [
            "board_id" => $request->board_id,
            "id" => $request->id,
        ]);
    }

    public function receiveFromAll(Request $request)
    {
        return view('boards.receiveFromAll', [
            "board_id" => $request->board_id,
            "id" => $request->id,
        ]);
    }

    public function create(Request $request)
    {
        $IfBoardHasPlayers = DB::table('players')
            ->where('board_id', $request->BoardId)
            ->count();
        if ($IfBoardHasPlayers == 0) {
            return view('boards.createPlayers', [
                "AmountOfPlayers" => $request->AmountOfPlayers,
                "BoardId" => $request->BoardId,
                "StartingBalance" => $request->StartingBalance,
            ]);
        } else {
            return redirect('/home');
        }
    }

    public function receivePanel(Request $request)
    {
        return view('boards.receivePanel', ['id' => $request->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function receiveStore(Request $request)
    {
        return Player::receiveStore($request);
    }

    public function sendToAnotherPlayer(request $request)
    {
        $playerId = $request->id;
        $board = DB::table('players')
            ->where('id', '=', $playerId)
            ->first();
        $boardId = $board->board_id;
        $players = DB::table('players')
            ->where('id', '!=', $playerId)
            ->where('board_id', '=', $boardId)
            ->get();
        return view('boards.sendToAnotherPlayer', [
            'playerId' => $playerId,
            'boardId' => $boardId,
            'players' => $players,
        ]);
    }

    public function sendToAnotherPlayerStore(request $request, $id)
    {
        return Player::sendToAnotherPlayerStore($request, $id);
    }

    public function sendBankStore(request $request)
    {
        return Player::sendBankStore($request);
    }

    public function sendToEveryoneStore(request $request)
    {
        return Player::sendToEveryoneStore($request);
    }

    public function receiveFromAllStore(request $request)
    {
        return Player::receiveFromAllStore($request);
    }

    public function store(PlayersStoreRequest $request)
    {
        return Player::store($request);
    }

    public function destroy($id)
    {
        //
    }
}
