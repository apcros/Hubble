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
      <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
    </head>
    <body>
    </body>
     <nav>
        <div class="nav-wrapper indigo">
          <a href="/" class="brand-logo">&nbsp; Hubble</a>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="/config">Config</a></li>
            <li><a href="/logout">Logout</a></li>
          </ul>
        </div>
      </nav>
      <div class='container'>
        @yield('content')
      </div>
    <footer class="page-footer indigo">
          <div class="container">
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2016 Apcros
            <a class="white-text right"><b>PRE-ALPHA</b> 0.01</a>
            </div>
          </div>
      </footer>
    </body>
</html>