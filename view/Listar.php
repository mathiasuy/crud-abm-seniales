</br>
</br>
</br>
<?php
$ctrChannel = ctrChannel::getInstance();

$lista = $ctrChannel->Index();
 foreach ($lista as $el) {
   echo  "</br>###############################</br>";
   //echo '<a href="/?cargar=Ver&id='.$el->get('id').'">'.$el->get('number').": ".$el->get('name').'</a>';
   echo '<a href="/?cargar=Ver&id='.$el->get('id').'"><u>IR AL CANAL '.$el->get('number').": ".$el->get('name').'</u></a>';
   echo  "</br>###############################</br>";
  echo  $el->toString()."</br>";
  echo  "</br>###############################</br>";
  }

 ?>
