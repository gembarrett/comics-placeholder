<?php
// include './config.php';
$privatekey = file_get_contents('./privkey');
$baseurl = 'http://gateway.marvel.com:80/v1/public/';
$section = 'characters';
$optional = '?name=hulk';
$time = time();
$apikey = file_get_contents('./apikey');
$hash = '&hash='.hash('md5',$time.$privatekey.$apikey);
$url = $baseurl.$section.$optional.'&ts='.$time.'&apikey='.$apikey.$hash;
$contents = file_get_contents($url);
$results = json_decode($contents);
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
