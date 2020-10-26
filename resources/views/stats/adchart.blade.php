<!DOCTYPE html>
<html>
 <head>
  <title>Στατιστικά αγγελιών</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <style type="text/css">
   .box{
    width:800px;
    margin:0 auto;
   }
  </style>
  <script type="text/javascript">
   var analytics = <?php echo $Category; ?>

   google.charts.load('current', {'packages':['corechart']});

   google.charts.setOnLoadCallback(drawCategoryChart);

   function drawCategoryChart()
   {
    var data = google.visualization.arrayToDataTable(analytics);
    var options = {
     title : 'Ποσοστό κατηγοριών ανά αγγελία'
    };
    var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
    chart.draw(data, options);
   }
 
   var municipalityanalytics = <?php echo $Municipality; ?>

   google.charts.load('current', {'packages':['corechart']});

   google.charts.setOnLoadCallback(drawMunicipalityChart);

   function drawMunicipalityChart()
   {
    var municipalitydata = google.visualization.arrayToDataTable(municipalityanalytics);
    var options = {
     title : 'Ποσοστό δήμων ανά αγγελία'
    };
    var chart = new google.visualization.PieChart(document.getElementById('municipalitypie_chart'));
    chart.draw(municipalitydata, options);
   }
  
   var regionanalytics = <?php echo $Region; ?>

   google.charts.load('current', {'packages':['corechart']});

   google.charts.setOnLoadCallback(drawRegionChart);

   function drawRegionChart()
   {
    var regiondata = google.visualization.arrayToDataTable(regionanalytics);
    var options = {
     title : 'Ποσοστό περιφερειών ανά αγγελία'
    };
    var chart = new google.visualization.PieChart(document.getElementById('regionpie_chart'));
    chart.draw(regiondata, options);
  }

    var stateanalytics = <?php echo $State; ?>

   google.charts.load('current', {'packages':['corechart']});

   google.charts.setOnLoadCallback(drawStateChart);

   function drawStateChart()
   {
    var statedata = google.visualization.arrayToDataTable(stateanalytics);
    var options = {
     title : 'Ποσοστό κατάστασης ανά αγγελία'
    };
    var chart = new google.visualization.PieChart(document.getElementById('statepie_chart'));
    chart.draw(statedata, options);
   }
  </script>
 </head>
 <body>
  <br />
  <div class="container">
   <h3 align="center">Laravel-Walker Statistic Chart</h3><br />
   
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title">Stats for categories, municipalities, regions and ad state</h3>
    </div>
    <div class="panel-body" align="center">
     <div id="pie_chart" style="width:750px; height:450px;">

     </div>
     <div id="municipalitypie_chart" style="width:750px; height:450px;">

     </div>
     <div id="regionpie_chart" style="width:750px; height:450px;">

     </div>

     <div id="statepie_chart" style="width:750px; height:450px;">

     </div>
    </div>
   </div>
   
  </div>
 </body>
</html>

