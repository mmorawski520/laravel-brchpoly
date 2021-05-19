@extends('layouts.app')

@section('content')
<div class="container text-center">
     @if($errors->any())
      <div class="w-4/8 m-auto text-center">
          @foreach($errors->all() as $error)
            <li  class="list-group-item list-group-item-action list-group-item-danger">{{$error}}</li>
        @endforeach
      </div>
  @endif
      <form action="{{route('settingsStore')}}" method="POST">
      @csrf
      @method("POST")
      <div class="form-group">
        <label for="fPassword">  <h1>{{__('old Password')}}</h1>
          <input type="password" name="fPassword" id="fPassword">
        </label>
      </div>
      <div class="form-group">
        <label for="nPassword">  <h1>{{__('new Password')}}</h1>
          <input type="password" name="nPassword" id="nPassword">
        </label>
      </div>
      <div class="form-group">
        <label for="nPasswordr">  <h1>{{__('new Password again')}}</h1>
          <input type="password" name="nPasswordr" id="nPasswordr">
        </label>
      </div>
         <button class="btn btn-danger mr-3"> {{__('change password')}}

      </button></form>
</div>

@endsection
