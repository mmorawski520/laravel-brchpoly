@extends('layouts.app')

@section('content')
<div class="d-flex  mx-auto text-center">
    <h2 class="d-flex  mx-auto text-center">{{__('addSomePlayers')}}</h2>
</div>
<div class="container">
  @if($errors->any())
      <div class="w-4/8 m-auto text-center">
          @foreach($errors->all() as $error)
            <li  class="list-group-item list-group-item-action list-group-item-danger">{{$error}}</li>
        @endforeach
      </div>
  @endif
  <form action="{{route('store',['AmountOfPlayers'=>$AmountOfPlayers,'BoardId'=>$BoardId,'StartingBalance'=>$StartingBalance])}}"method="POST">
 
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
    @for($i=0;$i<$AmountOfPlayers;$i++)
    <?php
     $j=$i;
     $j++;?>
    
  
      
      <label for="PlayerName{{$j}}">{{__('Player name')}} {{$j}}</label>
      <input type="text" class="block shadow-5xl mb-10 p-2 w-80 italic placeholder-gray-400 form-control" id="PlayerName{{$j}}"name="PlayerName{{$j}}" placeholder="{{__('Player name')}}">
    @endfor
    <button class="btn btn-dark mt-5">
          {{__('add players')}}
        </button>        
  </form>
  
</div>
@endsection
