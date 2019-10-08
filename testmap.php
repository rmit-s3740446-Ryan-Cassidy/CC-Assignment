<?php ini_set('display_errors',1);
error_reporting(E_ALL); ?>
<!DOCTYPE html>
<html>
  <head>
    <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet css -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
    
     <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>
    
      <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
      <a class="navbar-brand" href="#">Cloud Computing</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Stats
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="testmap.php">Map</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  </head>
  <body>
	 <?php  
	   /* Connect to MySQL and select the database. */
  $connection = mysqli_connect('database-1.chyh1wnf7bbo.ap-southeast-2.rds.amazonaws.com', 'admin', 'cloudpass');
  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
  $database = mysqli_select_db($connection, 'gtfs');
  $coords = array();
  $result = mysqli_query($connection, "SELECT * FROM coords");
while($query_data = mysqli_fetch_row($result)) {
  $latlon = array((float)$query_data[0], (float)$query_data[1]);
  $coords = $latlon;
}?>
	 
    <div id="map" style="width:800px; height: 500px;"></div>
	  <script>
    var coords = [-36.131004464822, 144.753202472532]; // the geographic center of our map
    var zoomLevel = 13; // the map scale. See: http://wiki.openstreetmap.org/wiki/Zoom_levels
    var map = L.map('map').setView(coords, zoomLevel);
    var latlngs = [<?php echo json_encode($coords); ?>];
		  window.alert(latlngs[1]);
    
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	maxZoom: 18,
	id: 'mapbox.streets',
	accessToken: 'pk.eyJ1IjoiaGVyYXN5IiwiYSI6ImNrMWcwbG9xNzB6azUzbW1tZ3drbTdxc2YifQ.IDi32Sz2mSNS1VlrvL21pQ'
}).addTo(map);
		  var polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
	  </script>
  </body>
</html>
