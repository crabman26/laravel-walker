<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Walker</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo asset('css/styles.css')?>" type="text/css"> 
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>       
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
 
<div class="container">
   <div class="row">
       <div class="col-md-12">
           <header>
               <nav id="admin-nav">
                   <ul>
                      @php
                        $role = Auth::user()->Role;
                      @endphp
                      @if($role == 'Administrator')
                        <li class="main-link"><a href="{{route('adsajax')}}">Αγγελίες</a></li>
                        <li class="main-link"><a href="{{route('categoriesajax')}}">Κατηγορίες</a></li>
                        <li class="main-link"><a href="{{route('regionajax')}}">Περιφέρειες</a></li>
                        <li class="main-link"><a href="{{route('municipalityajax')}}">Δήμοι</a></li>
                        <li class="main-link"><a href="{{route('usersajax')}}">Χρήστες</a></li>
                        <li class="main-link"><a href="{{url('contactform')}}">Φόρμες επικοινωνίας</a></li>
                        <li class="main-link"><a href="{{url('stats')}}">Στατιστικά στοιχεία</a></li>
                      @elseif($role == 'Member')
                        <li class="main-link"><a href="{{route('memberads')}}">Αγγελίες</a></li>
                        <li class="main-link"><a href="{{route('memberprofile')}}">Προφίλ</a></li>
                      @endif
                      @if(isset(Auth::user()->email))
                         <li class="last-link" data-email="{{ Auth::user()->email }}"><a href="{{ url('/main/logout') }}">Αποσύνδεση</a></li>
                      @else
                        <script>window.location = "/main";</script>
                      @endif
                   </ul>
               </nav>
           </header>
           <main>
                @yield('content')
           </main>
           <footer>
               
           </footer>
       </div>
   </div>
</div>
 
</body>
</html>