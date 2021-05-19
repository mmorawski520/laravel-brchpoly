@extends('layouts.app')

@section('content')
<div class="d-flex  mx-auto text-center">
    <h2 class="d-flex  mx-auto text-center">So you can create new board</h2>
</div>
<div class="container">
  @if($errors->any())
      <div class="w-4/8 m-auto text-center">
          @foreach($errors->all() as $error)
            <li  class="list-group-item list-group-item-action list-group-item-danger">{{$error}}</li>
        @endforeach
      </div>
  @endif
  <form action="{{route('boards.store')}}"method="POST">
 
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <label for="BoardName">{{__('Board Name')}}</label>
    <input type="text" class="block shadow-5xl mb-10 p-2 w-80 italic placeholder-gray-400 form-control" id="BoardName"name="BoardName" placeholder="{{__('Board Name')}}">
     <label for="salary">{{__('salary')}}</label>
    <input type="number" class="block shadow-5xl mb-10 p-2 w-80 italic placeholder-gray-400 form-control" id="salary"name="salary" >
      <label for="StartingBalance">{{__('Starting Balance')}}</label>

    <input type="number" class="block shadow-5xl mb-10 p-2 w-80 italic placeholder-gray-400 form-control" id="StartingBalance"name="StartingBalance" >
    <h6>{{__("Amount of players")}}</h6>
    <select  class="form-select form-select-lg mb-3 mt-3" id="AmountOfPlayers" name="AmountOfPlayers" >
        <option>2</option>
        <option>3</option>
        <option>4</option>
    </select>
    <button class="btn btn-dark">
          {{__('create')}}
        </button>        
  </form>
  
</div>
@endsection
