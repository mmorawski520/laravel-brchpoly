<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BoardStoreRequest;
use App\Http\Requests\PlayersStoreRequest;
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
           return Board::first()->getCurrentBoard($id); 
    }
    
    public function show($id)
    {
    }
    public function edit($id)
    {

    }

    public function store(BoardStoreRequest $request)
    {
      return Board::first()->storeBoard($request); 
    }

    public function update($id)
    {

    }
    public function destroy($id)
    {
        $board = Board::find($id);
        //anti spammer if
        if ($board != null)
        {
            $board->delete();
        }
        return redirect("/boards");
    }
}
