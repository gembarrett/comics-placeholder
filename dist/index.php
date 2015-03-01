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

?>


<!DOCTYPE html>
<html>
<head>
  <link type="text/css" rel="stylesheet" href="css/base.css" media="all" />
</head>
<body>
  <p><?php print_r($characterResults[0]->name);?></p>
  <p><?php print_r($characterResults[0]->description);?></p>
</body>
</html>
