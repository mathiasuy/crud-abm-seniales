</br>
</br>
</br>
</br>
</br>
<?php

$ctrDirectLink = ctrDirectLink::getInstance();
$canales = $ctrDirectLink->ListarXActivo(0);
echo "Antes de actualizar:</br>";
foreach ($canales as $c){
  //echo $c->toString();
}

$url = $ctrDirectLink->updateData($canales);
echo "Tras actualizar:</br>";
foreach ($canales as $c){
  echo $c->toString();
}

echo "<script>alert('Se modificaron $url enlaces a \'activo\'');</script>";

 ?>
