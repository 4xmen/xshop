@include('components.panel-header')
<div id="app">
    <canvas id="webgl"></canvas>
    <div id="raw">
       <div class="container">
           @yield('content')
       </div>
    </div>
</div>
@include('components.panel-footer')
