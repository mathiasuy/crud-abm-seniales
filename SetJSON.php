
<?php
include_once("dt/DtChannel.php");
include_once("model/clsDirectLink.php");
include_once("model/clsYouTube.php");
include_once("controller/ctrChannel.php");
$ctrChannel = new ctrChannel();

$arr = array();
$lista = $ctrChannel->Index();
 foreach ($lista as $el) {
  $arr[$el->get('number')] = $el->getData();
 }

$json = json_encode($arr);
 var_dump($json);

 ?>
