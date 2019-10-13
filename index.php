<!DOCTYPE html>
<?php
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
$bucketName = 'ccptvapp';
$IAM_KEY = 'AKIAWF2GCE4OTQ77KZDT';
$IAM_SECRET = 'Dt1o3ROc6db6bZSbleufErXUVh8xU9vYUTIx4ulm';
if (isset($_POST["submit"])) {
   
    //File info success TESTING PLEASE REMOVE LATER OR REPLACE
if ($_FILES["file"]["error"] > 0)
{
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
}
else
{
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["file"]["tmp_name"];
}


try {
    // You may need to change the region. It will say in the URL when the bucket is open
    // and on creation.
    $s3 = S3Client::factory(
    array(
    'credentials' => array(
    'key' => $IAM_KEY,
    'secret' => $IAM_SECRET
    ),
    'version' => 'latest',
    'region'  => 'ap-southeast-2'
        )
    );
} catch (Exception $e) {
    // We use a die, so if this fails. It stops here. Typically this is a REST call so this would
    // return a json object.
    die("Error: " . $e->getMessage());
}

// For this, I would generate a unqiue random string for the key name. But you can do whatever.
$keyName = 'key/' . basename($_FILES['file']['tmp_name']);
$pathInS3 = 'https://s3.ap-southeast-2.amazonaws.com/' . $bucketName . '/' . $keyName;

try {
    // Uploaded:
    $file = $_FILES['file']['tmp_name'];
    $s3->putObject(
        array(
            'Bucket'=>$bucketName,
            'Key' =>  $keyName,
            'SourceFile' => $file,
            'StorageClass' => 'REDUCED_REDUNDANCY'
        )
        );
} catch (S3Exception $e) {
    die('Error:' . $e->getMessage());
} catch (Exception $e) {
    die('Error:' . $e->getMessage());
}
}
?>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>GTFS Shapes Mapper</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
            <a class="nav-link" href="sample.php">Sample</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Page Content -->
  <div class="col-md-5 p-lg-5 mx-auto my-5">
  <div class="container">
  <div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="mt-5">Coordinates Mapping Application</h1>
        <p class="lead">Cloud Computing Semester 2 2019</p>
        <p class="lead">Ryan Cassidy & Vineet Bugtani</p>
        <ul class="list-unstyled">
          <li>Please select a csv coordinates file</li>
          <form action="index.php" method="post"
	enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<br />
<input type="submit" name="submit" value="Submit" />
</form>
        </ul>
      </div>
    </div>
    </div>
    </div>
  </div>
  </div>
  
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.slim.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>