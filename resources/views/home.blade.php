@extends('layouts.app')

@section('content')
<div class="d-flex  mx-auto text-center">
    <a type="button" class="btn btn-info mx-auto text-center" href="boards/create">{{__('Create new board')}}</a>
</div>
<div class="d-flex  mx-auto mt-4">
    <h1 class="mx-auto ">{{__('Your boards')}}  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
</svg></h1>
</div>
<div class="container mx-auto  mt-4">

    @forelse($boards as $board)
   

<div class="m-auto">
       
<div class="m-auto">
        <div class="float-right">
          <form class="float-left"  action="/boards/currentBoard/{{$board->id}}" method="GET">
             @csrf
            
           <button class="float-left btn btn-success mr-3"   >
              {{__('PLAY')}}
            </button>
          </form>
          <form class="float-left" action="{{route("edit",["id"=>$board->id])}}"method="GET">
            @csrf
            @method('get')
            <button type="submit"  class="mr-3 btn btn-info">
              {{__('EDIT')}} 
            </button>
          </form>
          <form class="float-left" action="/boards/{{$board->id}} "method="POST">
            @csrf
            @method('delete')
            <button type="submit"  class="btn btn-danger">
              {{__('DELETE')}} 
            </button>
          </form>
        </div>
             
            <h2 class="text-gray-700 text-5xl hover:text-gray-500" >
              
                   {{$board->board_name}}
               
            </h2>
            <p class="text-lg text-gray-700 py-6">
               
            </p>
            <hr class="mt-5 mb-8">
      </div>
   @empty
   <div>
        <h2 class="text-center">{{__('noBoards')}} </h2>
   </div>
   @endforelse
    <div class="d-flex mt-5">
    <div class="mx-auto">
        {!! $boards->links() !!}
    </div>
</div>

</div>

@endsection
