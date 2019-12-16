<!DOCTYPE html>
<html lang="en">

@include('partials.header')
<body style="height:100%;">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        @include('partials.navbar')
        @include('partials.sidebar')
    </nav>
    
    <div id="page-wrapper" >
    {{-- @include('partials.cards') --}}
    @if(Session::has('message'))
        <p id="message" style="color:black" class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    @yield('content')
    </div>
    @include('partials.footer')
</body>
</html>