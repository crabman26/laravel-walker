
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
               <nav id="usernav-header">
                  <ul>
                    <li><a href="{{ url('login') }}">Σύνδεση |</a></li>
                    <li><a href="{{ url('register') }}">Εγγραφή</a></li>
                  </ul>
               </nav>
               <nav id="navbar-header">
                   <ul>
                        <li class="main-link"><a href="{{ url('about') }}">Εταιρεία</a></li>
                        <li class="main-link"><a href="{{ url('contact') }}">Επικοινωνία</a></li>
                        <li class="main-link"><a href="{{ url('terms') }}">Όροι Χρήσης</a></li>                 
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
                   </ul>
               </nav>
           </footer>
       </div>
   </div>
</div>
 <script>
$(document).ready(function(){
 $('#keyword_name').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('categoriesajax.fetchkeywords') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
           $('#KeywordList').fadeIn();  
           $('#KeywordList').html(data);
          }
         });
        }
    });

  $("#area_name").keyup(function(){
      var area = $(this).val();
      if (area != ''){
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url: "{{ route('municipalityajax.fetchmunicipalities')}}",
          method:"POST",
          data:{area:area, _token:_token},
          success:function(data){
            $('#AreaList').fadeIn();
            $("#AreaList").html(data);
          }
        })
      }
  });

  $(document).on('click', 'li', function(){  
        var keyword = $(this).text();
        $('#keyword_name').val($(this).text());  
        $('#KeywordList').fadeOut();
        location.href = 'ads/'+keyword;
    });

  // $(document).on('click','li',function(){
  //     var area = $(this).text();
  //     $('#area_name').val($(this).text());
  //     $('#AreaList').fadeOut();
  //     location.href = 'ads/'+area;

  // });


});

 
</script>
</body>
</html>

