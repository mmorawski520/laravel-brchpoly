@extends('layouts.app')

@section('content')
<div class="container">
  <?php
  $data=DB::table('players')->where('id','=',$id)->select("board_id")->first();
  ?>
  <form   action="/boards/currentBoard/{{$data->board_id}}" method="get">
@csrf
<button class="btn btn-info mx-auto text-center mb-3" >{{__("back to the board")}}</button>
</form>
  <h1 class="mb-5">{{__('whereMoney')}}</h1>
     @if($errors->any())
      <div class="w-4/8 m-auto text-center">
          @foreach($errors->all() as $error)
            <li  class="list-group-item list-group-item-action list-group-item-danger">{{$error}}</li>
        @endforeach
      </div>
  @endif

      <form action="{{route('sendBank',['id'=>$id,'board_id'=>$board_id])}}" method="GET">
      @csrf
      @method("GET")
         <button  class="btn btn-info btn-lg btn-block">Bank</button></form>
           <form action="{{route('sendToAnotherPlayer',['id'=>$id,'board_id'=>$board_id])}}" method="GET">
      @csrf
      @method("GET")
         <button  class="btn btn-danger btn-lg btn-block mt-5">{{__('Another player')}}</button></form>
          <form action="{{route('sendToEveryone',['id'=>$id,'board_id'=>$board_id])}}" method="GET">
      @csrf
      @method("GET")
         <button  class="btn btn-warning btn-lg btn-block mt-5">{{__('Everyone')}}</button></form>
</div>

@endsection
