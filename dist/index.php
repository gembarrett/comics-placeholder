<?php
include './config.php';

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
