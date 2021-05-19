

@extends('layouts.app')
@section('content')
<div class="d-flex  mx-auto text-center">
   <h1 class="d-flex  mx-auto text-center">{{__('This is Board')}} {{$board->board_name}}</h1>
</div>
<div class="container px-auto">
   <div class="mt-5">
       <form class="" action="{{route('action',['id'=>0,'board_id'=>$board->id,'task'=>'every'])}}" method="GET">
            @csrf
            <button class="d-flex mx-auto text-center btn btn-warning mr-3 mb-5">{{__('Whole history')}}
            </button>
         </form>
      </div>
   <div class="row"  style="height:24em;width:auto;">
      @for($i=0;$i<4;$i++)
      <div class="col-lg   border">
         @if(!empty($players[$i]))
         <h2>
         {{$players[$i]->nickname}}
         <h2>
         <h2>{{__("balance")}} {{$players[$i]->players_balance}}$</h2>
         @if($players[$i]->bankrupt==0)
         <form action="{{route('receivePanel',['id'=>$players[$i]->id])}}" method="GET">
            @csrf
            <button class="float-left btn btn-success mr-3 mb-3">{{__("Receive")}}
            </button>
         </form>
         <form action="{{route('send',['id'=>$players[$i]->id,'board_id'=>$board->id])}}" method="GET">
            @csrf
            <button  class="float-left btn btn-danger mr-3 mb-3">{{__('send')}}</button>
         </form>
         <form action="{{route('salary',['id'=>$players[$i]->id,'board_id'=>$board->id])}}" method="GET">
            @csrf
            <button class="float-left btn btn-info mr-3 mb-3">{{__('salary')}}
            </button>
         </form>
         <form action="{{route('action',['id'=>$players[$i]->id,'board_id'=>$board->id,'task'=>'current'])}}" method="GET">
            @csrf
            <button class="float-left btn btn-warning mr-3 mb-3">{{__('History')}}
            </button>
         </form>
         
         @endif
         @endif
      </div>
      @endfor

   </div>
 
</div>

@endsection

