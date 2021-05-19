<?php

namespace App\Http\Controllers;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $user_id=auth()->user()->id;
        //$boards = DB::select('select * from boards where user_id = ?', [$user_id]);
        $boards=Board::where("user_id","=",$user_id)->orderBy("created_at","DESC")->paginate(7);
        return view('home')->with("boards",$boards);
    }
}
