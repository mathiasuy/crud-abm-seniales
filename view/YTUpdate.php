</br>
</br>
</br>
<br>
<br>
<br>
<br>
<br>
<?php

$ctrYouTube = ctrYouTube::getInstance();
//$ctrDirectLink = ctrDirectLink::getInstance();
$canales = $ctrYouTube->Index();
echo "Antes de actualizar:</br>";
foreach ($canales as $c){
  echo $c->toString();
}

//$url = $ctrDirectLink->updateData();
$yt_ = $ctrYouTube->updateData($canales);
echo "Tras actualizar:</br>";
foreach ($canales as $c){
  echo $c->toString();
}

//echo "Se modificaron $url enlaces rotos a 'inactivo'";
echo "<script>alert('Se actualizó la información de $yt_ videos de YouTube');</script>";


 ?>
