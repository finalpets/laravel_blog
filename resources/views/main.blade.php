<!DOCTYPE html>
<html lang="en">
  <head>
    @include('partials._head')
  </head>
  <body>
    @include('partials._nav')  

    <div class="container">
      @include('partials._messages')

      <!-- {{ Auth::check() ? "Logged In" : "Log Out" }} -->

      @yield('content')

      @include('partials._footer')
    </div> <!-- End of the Conteiner -->

    @include('partials._javascript')
    @yield('scripts')
  </body>
</html>