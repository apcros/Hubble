<!DOCTYPE html>
  <html>
    <head>
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="{{ asset('css/materialize.min.css') }}"  media="screen,projection"/>
      <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
      <meta charset="UTF-8"/>
      <title>@yield('title')</title>
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="{{ asset('js/handlebars.min-latest.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/hubble.js') }}"></script>
    </head>
    <body>
    </body>
     <nav>
        <div class="nav-wrapper indigo">
          <a href="/" class="brand-logo">&nbsp; Hubble</a>
          <a href="#" data-activates="mobile-btn" class="button-collapse"><i class="fa fa-bars" aria-hidden="true"></i></a>
          <ul class="right hide-on-med-and-down">
            <li><a href="/devices"><i class="fa fa-server left" aria-hidden="true"></i>Devices</a></li>
            <li><a href="/settings"><i class="fa fa-cogs left" aria-hidden="true"></i>Settings</a></li>
          </ul>
          <ul class="side-nav" id="mobile-btn">
            <li><a href="/devices">Devices</a></li>
            <li><a href="/settings">Settings</a></li>
          </ul>
        </div>
      </nav>
        @yield('content')
    <footer class="page-footer indigo">
          <div class="container">
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2016 Apcros
            <a class="white-text right"><b>{{ config('app.hubble_version') }}</b></a>
            </div>
          </div>
      </footer>
      <script type="text/javascript">
        $(document).ready(function(){
           $(".button-collapse").sideNav();
        });
      </script>
    </body>
</html>