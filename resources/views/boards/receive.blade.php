@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{ redirect()->back()->getTargetUrl()}}" method="get">

<button class="btn btn-info mx-auto text-center mb-3" >{{__("back to the board")}}</button>
</form>
     @if($errors->any())
      <div class="w-4/8 m-auto text-center">
          @foreach($errors->all() as $error)
            <li  class="list-group-item list-group-item-action list-group-item-danger">{{$error}}</li>
        @endforeach
      </div>
  @endif
      <form action="{{route('receiveStore',['id'=>$id,'board_id'=>$board_id])}}" method="GET">
      @csrf
      @method("GET")
        <label for="ReceiveValue">  <h1>{{__('Enter value')}}</h1>
          <input type="number" name="ReceiveValue" id="ReceiveValue">
        </label>
        <br>
         <button class="btn btn-success mr-3 mt-3">{{__('Receive')}}

      </button></form>
</div>

@endsection
