@extends('layouts.app')

@section('content')
<div class="container text-center">
	<h1 class="mb-5">{{__("settingsH1")}}</h1>
	 @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
	<form action="{{route('settingsChange')}}" method="GET">
      @csrf
      @method("GET")
	<button class="btn btn-info mb-5">{{__("change password")}}</button><br>
</form>
<form action="{{route('deleteForm')}}" method="GET">
      @csrf
      @method("GET")
	<button class="btn btn-info mb-5">{{__("delete account")}}</button><br>
</form>
	
</div>
@endsection