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
   
     <!-- Leaflet-Image -->
<script src='https://unpkg.com/leaflet-image@latest/leaflet-image.js'></script>

	    <!-- AWS SDK -->
<script src="aws-sdk-2.548.0.min.js"></script>
    
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
	  <!-- added -->
<div id="images">
</div>
<input id="btn" type="button" value="Send email" onclick="emailFunction(); alert('Email sent');"/>
     <script type="text/javascript">
     function emailFunction() {
            'use strict';
//AWS Region
var aws_region = "ap-southeast-2";
//From Address - Requires Pinpoint Verification
var senderAddress = "herasy@gmail.com";
//To Address
var toAddresses = [ "vineet.bugtani@icloud.com" ];
//Subject Line
var subject = "Cloud Computing - Map";
//Email Body
var body_text = `Amazon Pinpoint Test (SDK for JavaScript in Node.js)
----------------------------------------------------
This email was sent with Amazon Pinpoint using the AWS SDK for JavaScript in Node.js.
For more information, see https:\/\/aws.amazon.com/sdk-for-node-js/`;
	     
var myDiv = document.getElementById("images").innerHTML;
//html body
var body_html = `<html>
<head></head>
<body>
  <h1>Amazon Pinpoint Test (SDK for JavaScript in Node.js)</h1>
  <p>This email was sent with
    <a href='https://aws.amazon.com//pinpoint/'>the Amazon Pinpoint Email API</a> using the
    <a href='https://aws.amazon.com//sdk-for-node-js/'>
      AWS SDK for JavaScript in Node.js</a>.</p>
<div id="myImg"></div>
<!-- //14/10 -->
<!-- myDiv 14/10 -->
</body>
</html>`;
// Message Tags
var tag0 = { 'Name':'key0', 'Value':'value0' };
var tag1 = { 'Name':'key1', 'Value':'value1' };
//Character Encoding
var charset = "UTF-8";

//AWS Creds
AWS.config.credentials = new AWS.Credentials('AKIAWF2GCE4OTQ77KZDT', 'Dt1o3ROc6db6bZSbleufErXUVh8xU9vYUTIx4ulm');
//Update region
AWS.config.update({region:aws_region});
//Create a new PinpointEmail object.
var pinpointEmail = new AWS.PinpointEmail();
// Specify the parameters to pass to the API.
var params = {
  FromEmailAddress: senderAddress,
  Destination: {
    ToAddresses: toAddresses
  },
  Content: {
    Simple: {
      Body: {
        Html: {
          Data: myDiv,
          Charset: charset
        },
        Text: {
          Data: body_text,
          Charset: charset
        }
      },
      Subject: {
        Data: subject,
        Charset: charset
      }
    }
  },
  EmailTags: [
    tag0,
    tag1
  ]
};
//Try to send the email.
 pinpointEmail.sendEmail(params, function(err, data) {
  // If something goes wrong, print an error message.
  if(err) {
    console.log(err.message);
  } else {
    console.log("Email sent! Message ID: ", data.MessageId);
  }
});
 }
    </script>
	  
	
	  <?php  
  //Connect to our MySQL Database and retrieve coords
  $connection = mysqli_connect('database-1.chyh1wnf7bbo.ap-southeast-2.rds.amazonaws.com', 'admin', 'cloudpass');
  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
  $database = mysqli_select_db($connection, 'gtfs');
  $coords = array();
  $result = mysqli_query($connection, "SELECT * FROM coords");
while($query_data = mysqli_fetch_array($result)) {
  $coords[] = array((float)$query_data['lat'], (float)$query_data['lon']);
}
	  echo count($coords);  ?>
	  <!-- Leaflet Map -->
    <div id="map" style="width:800px; height: 500px;"></div>
	  <script>
	  //Create leaflet map object
		 var map = L.map('map', {
    center: [-37.8183431013018, 144.952513264004],
    zoom: 13,
    preferCanvas: true
});
	  //Parse the coords array
    var latlngs = JSON.parse('<?php echo json_encode($coords); ?>');

    //Mapbox Tilelayer
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	maxZoom: 18,
	id: 'mapbox.streets',
	accessToken: 'pk.eyJ1IjoiaGVyYXN5IiwiYSI6ImNrMWcwbG9xNzB6azUzbW1tZ3drbTdxc2YifQ.IDi32Sz2mSNS1VlrvL21pQ'
}).addTo(map);

    //Coordinates Polyline
	var polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
	map.fitBounds(polyline.getBounds());

	//Create Canvas Image  
	leafletImage(map, function(err, canvas) {
    var img = document.createElement('img');
    var dimensions = map.getSize();
    img.width = dimensions.x;
    img.height = dimensions.y;
    img.src = canvas.toDataURL(); 
document.getElementById('images').innerHTML = '';
document.getElementById('images').appendChild(img);
document.getElementById("images").style.display = "none";		  
});
		
	  </script>
  </body>
</html>