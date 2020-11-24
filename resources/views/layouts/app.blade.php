<!doctype html>
<html lang="en">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-176651432-2"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Symetry 2020 Example</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <!--<link rel="stylesheet" href="/resources/demos/style.css">    
   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet"/>   -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet"/>
   <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>    

<div class="container" style="margin-top:30px;">

<p class="ui-state-default ui-corner-all ui-helper-clearfix" style="padding:4px;">
  Asymmetries in the disturbance compensation
methods for the stable and unstable first order plants
</p>

 <!--<div id="loader" class="loader"> 
<img src="img/loading.gif" alt="loading">
</div>--> 

@yield('content')
 
 
@yield('js')
</body>
</html>