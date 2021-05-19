@extends('layouts.app')

@section('content')
 
<div class="d-flex  mx-auto mt-4">
    <h1 class="mx-auto ">{{__('Your moves')}}  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
</svg></h1>
</div>
<div class="container mx-auto  mt-4">
	<div class="m-auto">
		<form action="{{route("currentBoard",["id"=>$players_in_board[0]->board_id])}}" method="get">

<button class="btn btn-info mx-auto text-center mb-3" >{{__("back to the board")}}</button>
</form>
</div>
    @forelse($actions as $action)
   

<div class="m-auto">
        
<div class="m-auto">
        <div class="float-right">
          
            <form class="float-left" action="/players_actions/{{$action->id}} "method="POST">
            @csrf
            @method('delete')
        
            <button type="submit"  class="btn btn-danger">
             {{__("DELETE")}} 
            </button>
          </form>
          <br>
          @if($action->action_type!="salary")
           <form class="float-left" action="{{route("editAction",["id"=>$action->id])}} "method="GET">
            @csrf
            @method('get')
        
            <button type="submit"  class="btn btn-info mt-3">
             {{__("EDIT")}} 
            </button>
          </form>
          @endif
        </div>
             <h2>{{$players_in_board->where('id',"=",$action->player_id)->pluck("nickname")->first()}}</h2>
            <h2 class="text-gray-700 text-5xl hover:text-gray-500" >
            	{{__('action:')}} 
              	 @if($action->action_type=="receive")
                     {{__('received money')}} 
                  @elseif($action->action_type=="salary")
                  	{{__('received salary')}}
                 @elseif($action->action_type=="send_to_bank")
                 	{{__('sent money to bank')}}
                  @elseif($action->action_type=="send_to_everyone")
                  {{__('sent money to everyone')}}
                  @elseif($action->action_type=="receive_from_everyone")
                  {{__('received money from everyone')}}
                 @elseif($action->action_type=="send_to_another_player")
                 	<!--idk why value("nickname") didn't work ;-;-->
                 	{{__('Money has been sent to the player')}} {{$players_in_board->where('id',"=",$action->enemy_id)->pluck("nickname")->first()}}
               	@endif  
            </h2>
            <p class="text-lg  text-muted">
            	@if($action->action_type=="receive" || $action->action_type=="salary"|| $action->action_type=="receive_from_everyone")
               +{{$action->amount}}
             
               @else
                -{{$action->amount}}
               @endif
            </p>
            <h5>{{$action->updated_at}}</h5>
            <hr class="mt-5 mb-8">
             
            
      </div>

   @empty
   <div>
        <h2 class="text-center">{{__("playersActions")}} </h2>
   </div>
   @endforelse
    <div class="d-flex mt-5">
    <div class="mx-auto">
        {!! $actions->links() !!}
    </div>
</div>

</div>

@endsection
