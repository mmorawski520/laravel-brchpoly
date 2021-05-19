@yield('nav')
 <div id="app">
        <nav class="navbar navbar-expand-md  navbar-dark bg-success  " >
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                 <a class="navbar-brand" href="{{route('about') }}"
                                       onclick="{{route('about')}}">
                                            {{ __('about') }}
                                    </a>
                 <a class="navbar-brand" href="{{route('contact') }}"
                                       onclick="{{route('contact')}}">
                                            {{ __('contact') }}
                                    </a>
                <a class="navbar-brand" href="{{route("changeLang",['lang'=>'en'])}}" onclick="{{route("changeLang",['lang'=>'en'])}}">
                    ENG
                </a>
                <a class="navbar-brand" href="{{route("changeLang",['lang'=>'pl'])}}"onclick="{{route("changeLang",['lang'=>'pl'])}}">
                    PL
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown ">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right bg-success text-white" aria-labelledby="navbarDropdown" >
                                     <a class="dropdown-item text-white" href="{{ route('home') }}"
                                       onclick="{{redirect()->route('home')}}">
                                            {{ __('Your boards') }}
                                    </a>
                                     <a class="dropdown-item  text-white" href="{{route('settingsPanel')}}"
                                       onclick="{{redirect("settings/index")}}">
                                            {{ __('Settings') }}
                                    </a>
                                   
                                     <a class="dropdown-item  text-white" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        
                                        {{ __('Logout') }}

                                       
                                    </a>
                                   


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>