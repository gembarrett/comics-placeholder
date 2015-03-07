<?php
// include './config.php';

// terms of use state the page has to show attribution
$attributionHTML = "<a href='http://marvel.com'>Data provided by Marvel. © 2015 MARVEL</a>";

// get keys from files
$privatekey = file_get_contents('./privkey');
$apikey = file_get_contents('./apikey');

// create the basic request
$baseurl = 'http://gateway.marvel.com:80/v1/public/';
$section = 'characters';
$time = time();

$characterName = "hulk";
$characterFile = $characterName.'-image';

$optional = '?name='.$characterName;

// build hash of timestamp and keys
$hash = '&hash='.hash('md5',$time.$privatekey.$apikey);

// create request url
$url = $baseurl.$section.$optional.'&ts='.$time.'&apikey='.$apikey.$hash;

// all potential image sizes
$sizes = [
  "portrait_small.jpg" => "50px x 75px",
  "portrait_medium.jpg" => "100px x 150px",
  "portrait_xlarge.jpg" => "150px x 225px",
  "portrait_fantastic.jpg" => "168px x 252px",
  "portrait_uncanny.jpg" => "300px x 450px",
  "portrait_incredible.jpg" => "216px x 324px",
  "standard_small.jpg" => "65px x 45px",
  "standard_medium.jpg" => "100px x 100px",
  "standard_large.jpg" => "140px x 140px",
  "standard_xlarge.jpg" => "200px x 200px",
  "standard_fantastic.jpg" => "250px x 250px",
  "standard_amazing.jpg" => "180px x 180px",
  "landscape_small.jpg" => "120px x 90px",
  "landscape_medium.jpg" => "175px x 130px",
  "landscape_large.jpg" => "190px x 140px",
  "landscape_xlarge.jpg" => "270px x 200px",
  "landscape_amazing.jpg" => "250px x 156px",
  "landscape_incredible.jpg" => "464px x 261px",
  "detail.jpg" => "full image constrained to 500px wide"
];

// grab image link from local file if it exists
if (file_exists($characterFile)) {
  $imageURL = file_get_contents($characterName.'-image');
}
else {
  // get the json, chuck into a variable and decode
  $contents = json_decode(file_get_contents($url));  
  // test out putting results on page
  $characterResults = $contents->data->results;
  // get the image url
  $imageURL = $characterResults[0]->thumbnail->path."/";
  // create name for file to hole image url
  $fileName = $characterName.'-image';
  // put the image url into a local file
  file_put_contents($fileName, $imageURL);
}

?>


<!DOCTYPE html>
<html>
<head>
  <link type="text/css" rel="stylesheet" href="css/base.css" media="all" />
</head>
<body>
  <?php print_r($attributionHTML);?>
  <!-- <p><?php print_r($characterResults[0]->name);?></p>
  <p><?php print_r($characterResults[0]->description);?></p> -->
  <?php
  foreach ($sizes as $key => $value) {
      echo "<img src='$imageURL$key' />";
  }
  ?>
</body>
</html>
