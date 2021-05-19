
@extends('layouts.app')

@section('content')

<div class="container">
  <form action="{{ route('send',['id'=>$playerId,'board_id'=>$boardId])}}" method="get">

<button class="btn btn-info mx-auto text-center mb-3" >{{__("back")}}</button>
</form>
     @if($errors->any())
      <div class="w-4/8 m-auto text-center">
          @foreach($errors->all() as $error)
            <li  class="list-group-item list-group-item-action list-group-item-danger">{{$error}}</li>
        @endforeach
      </div>
  @endif
      <form action="{{route('sendToAnotherPlayerStore',['id'=>$playerId,'boardId'=>$boardId])}}" method="GET">

      @csrf
      @method("GET")
      <h2>{{__("Choose player")}}</h2>
       <select name="toPlayer" id="toPlayer">
@foreach($players as $player)
	<option>{{$player->nickname}}</option>

@endforeach
</select>
<br>
<label for="ReceiveValue">  <h2>{{__('Enter value')}}</h2>
          <input type="number" name="ReceiveValue" id="ReceiveValue">
        </label>
        <br>
         <button class="btn btn-danger mr-3">{{__('send')}}

       </form>
</div>

@endsection
