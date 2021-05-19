@extends('layouts.app')

@section('content')
<div class="container">
  <?php
  $data=DB::table('players')->where('id','=',$id)->select("board_id")->first();
  ?>
  <form action="{{ route('currentBoard',['id'=>$data->board_id])}}" method="get">

<button class="btn btn-info mx-auto text-center mb-3" >{{__("back")}}</button>
</form>
     <form action="{{route('receive',['id'=>$id])}}" method="GET">
            @csrf
            <button class="float-left btn btn-success mr-3 mb-3">{{__("Receive from bank")}}
            </button>
         </form>

     <form action="{{route('receiveFromAll',['id'=>$id])}}" method="GET">
            @csrf
            <button class="float-left btn btn-success mr-3 mb-3">{{__("Receive from everyone")}}
            </button>
         </form>
</div>

@endsection
