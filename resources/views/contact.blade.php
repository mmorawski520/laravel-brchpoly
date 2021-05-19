@extends('layouts.app')

@section('content')
<h1 class="text-center">{{__('contactTitle')}}</h1>
<section class='container mt-5'>
         <div class='contact' style='float:left;'>
            <img src="{{asset('logo.jpg')}}" class='logo'>
         </div>
         <div class='data ml-5' style='float:left;margin-top:3em;'>
            <h1 >Name and surname</h1>
            <br>
            <h2>Mail</h2>
            <br>
            <h2>{{__("contactPhone")}} 000 000 000</h2>
         </div>
      </section>
@endsection