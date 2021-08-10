<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\BoardStoreRequest;
use App\Http\Requests\PlayersStoreRequest;
use App\Http\Requests\editBoardRequest;
use Illuminate\Http\Request;

use App\Models\Board;


class BoardsController extends Controller
{
    public function index()
    {
        return redirect('/home');
    }

    public function create()
    {
        return view('boards.create');
    }

    public function currentBoard($id)
    {
        return Board::getCurrentBoard($id);
    }


    public function edit($id)
    {
        $board = Board::find($id);
        return view("boards.edit", ["board" => $board]);
    }

    public function store(BoardStoreRequest $request)
    {
        return Board::storeBoard($request);
    }

    public function reset($id)
    {

        return Board::reset($id);
    }

    public function update(editBoardRequest $request)
    {

//return $request;
        return Board::updateBoard($request);
        //return redirect("/boards");

    }

    public function destroy($id)
    {
        $board = Board::find($id);
        //anti spammer if
        if ($board != null) {
            $board->delete();
        }
        return redirect("/boards");
    }
}
