
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Walker</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo asset('css/styles.css')?>" type="text/css"> 
</head>
<body>
 
<div class="container">
   <div class="row">
       <div class="col-md-12">
           <header>
                <a href="{{ url('index') }}"><img src="<?php echo asset('images/logo.png')?>" alt="logo"/></a>
               <nav id="navbar-header">
                   <ul>
                        <li class="main-link"><a href="{{ url('about') }}">Εταιρεία</a></li>
                        <li class="main-link"><a href="{{ url('contact') }}">Επικοινωνία</a></li>
                        <li class="main-link"><a href="{{ url('terms') }}">Όροι Χρήσης</a></li>
                        <li class="main-link"><a href="{{ url('login') }}">Σύνδεση</a></li>
                   </ul>
               </nav>
           </header>
           <main>
                @yield('content')
           </main>
           <footer>
               <nav id="navbar-footer">
                   <ul>
                        <li class="main-link"><a href="{{ url('about') }}">Εταιρεία</a></li>
                        <li class="main-link"><a href="{{ url('contact') }}">Επικοινωνία</a></li>
                        <li class="main-link"><a href="{{ url('terms') }}">Όροι Χρήσης</a></li>
                        <li class="main-link"><a href="{{ url('login') }}">Σύνδεση</a></li>
                   </ul>
               </nav>
           </footer>
       </div>
   </div>
</div>
 
</body>
</html>

