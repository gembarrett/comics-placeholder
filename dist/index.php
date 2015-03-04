<?php
// include './config.php';

// get keys from files
$privatekey = file_get_contents('./privkey');
$apikey = file_get_contents('./apikey');

// create the basic request
$baseurl = 'http://gateway.marvel.com:80/v1/public/';
$section = 'characters';
$optional = '?name=hulk';
$time = time();

// build hash of timestamp and keys
$hash = '&hash='.hash('md5',$time.$privatekey.$apikey);

// create request url
$url = $baseurl.$section.$optional.'&ts='.$time.'&apikey='.$apikey.$hash;

// get the json, chuck into a variable and decode
$contents = file_get_contents($url);
$results = json_decode($contents);

// chuck the json into a separate file - TODO: refactor so results get decoded and into file in fewer steps
file_put_contents('results.json', $contents);

// test out putting results on page
$characterResults = $results->data->results;

$imageSize = "detail";

$sizes = [
  "portrait_small" => "50px x 75px",
  "portrait_medium" => "100px x 150px",
  "portrait_xlarge" => "150px x 225px",
  "portrait_fantastic" => "168px x 252px",
  "portrait_uncanny" => "300px x 450px",
  "portrait_incredible" => "216px x 324px",
  "standard_small" => "65px x 45px",
  "standard_medium" => "100px x 100px",
  "standard_large" => "140px x 140px",
  "standard_xlarge" => "200px x 200px",
  "standard_fantastic" => "250px x 250px",
  "standard_amazing" => "180px x 180px",
  "landscape_small" => "120px x 90px",
  "landscape_medium" => "175px x 130px",
  "landscape_large" => "190px x 140px",
  "landscape_xlarge" => "270px x 200px",
  "landscape_amazing" => "250px x 156px",
  "landscape_incredible" => "464px x 261px",
  "detail" => "full image constrained to 500px wide"
];

?>


<!DOCTYPE html>
<html>
<head>
  <link type="text/css" rel="stylesheet" href="css/base.css" media="all" />
  <script type="text/javascript">
    var test = <?php echo $time ?>;
    console.log(test);
  </script>
</head>
<body>
  <?php print_r($results->attributionHTML);?>
  <p><?php print_r($characterResults[0]->name);?></p>
  <p><?php print_r($characterResults[0]->description);?></p>
  <img src="<?php echo $characterResults[0]->thumbnail->path."/".$imageSize.".jpg";?>" />
  <ul>
  <?php
  foreach ($sizes as $value) {
      echo "<li>$value</li>";
  }
  ?>
  </ul>
</body>
</html>
