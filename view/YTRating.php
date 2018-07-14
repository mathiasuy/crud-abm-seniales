</br>
</br>
</br>
</br>
</br>
<?php
$ctrYouTube = ctrYouTube::getInstance();
$canales = $ctrYouTube->ListarXActivo(1);

echo "Trayendo datos de YT de canales marcados como activos:</br>";
echo "</br>";
echo "Antes de actualizar:</br>";
foreach ($canales as $c){
  echo $c->getBasico();
}

$yt_ = $ctrYouTube->updateRating($canales);
echo "Tras actualizar:</br>";
foreach ($canales as $c){
  echo $c->getBasico();
}

echo "<script>alert('Se actualizó la información de $yt_ videos de YouTube');</script>";
 ?>
