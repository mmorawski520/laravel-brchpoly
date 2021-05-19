@extends('layouts.app')

@section('content')
<div class="container">
     @if($errors->any())
      <div class="w-4/8 m-auto text-center">
          @foreach($errors->all() as $error)
            <li  class="list-group-item list-group-item-action list-group-item-danger">{{$error}}</li>
        @endforeach
      </div>
  @endif
      <form action="{{route('deleteAccountStore')}}" method="POST">
      @csrf
      @method("POST")
        <label for="ReceiveValue">  <h1>{{__('Enter password')}}</h1>
          <input type="password" name="ReceiveValue" id="ReceiveValue">
        </label>
         <button class="btn btn-danger mr-3">{{__('delete account')}}

      </button></form>
</div>

@endsection
