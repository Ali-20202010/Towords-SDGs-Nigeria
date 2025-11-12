<!doctype html>
<html>
<head>
   @include('layout.head')
</head>
<body>
   @include('layout.header')
   <div id="main" class="">
           @yield('content')
   </div>
   @include('layout.footer')
</body>
</html>