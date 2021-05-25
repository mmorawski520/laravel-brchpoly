@extends('layouts.app')

@section('content')
<div class="w-4/8 m-auto text-center mb-4">
          @foreach($errors->all() as $error)
            <li  class="list-group-item list-group-item-action list-group-item-danger">{{$error}}</li>
        @endforeach
      </div>
<div class="d-flex mt-4  mx-auto text-center">
    <a type="button" class="btn btn-info mx-auto text-center" href="{{route("home")}}">{{__('Back to the menu')}}</a>
</div>
 
<div class="container mx-auto  mt-4 mb-4">
  <h1>{{__("Change what you want")}}</h1>
  <form action="{{route("update",["id"=>$board->id])}}"method="POST">
    @csrf
    @method("POST")
   <div class="form-group">
    <label for="boardName">{{__("current board name")}} <strong>{{$board->board_name}}</strong></label>
    <input type="text" class="form-control" name="boardName" id="boardName">
    </div>
    <div class="form-group">
    <label for="salary">{{__("current salary")}} <strong>{{$board->salary}}</strong></label>
     <input type="text" class="form-control" name="salary" id="salary">
  </div>
  <div class="form-group">
    <label for="startingBalance">{{__("current starting balance")}} <strong>{{$board->starting_balance}}</strong></label>

     <input type="text" class="form-control" name="startingBalance" id="startingBalance">
  </div>
  <button class="float-left btn btn-warning mr-3 mb-3">{{__('Change')}}
            </button>
    </form>
</div>

@endsection
