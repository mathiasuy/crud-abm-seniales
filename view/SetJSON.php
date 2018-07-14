</br>
</br>
</br>
</br>
</br>
<?php
$ctrChannel = ctrChannel::getInstance();

$arr = array();
$lista = $ctrChannel->ListarXActivo(1);

usort($lista, 'sort_by_orden');
function sort_by_orden ($a, $b) {
    return $a->get('number') - $b->get('number');
}

$str = "var ch = [     ";
$str .= "\n"." {              ";
$str .= "\n"."      nombre          : 'dummy',";
$str .= "\n"."      numero          : '0',";
$str .= "\n"."      id              : '0',";
$str .= "\n"."      video           : undefined,";
$str .= "\n"."      medio           : '1',";
$str .= "\n"."      activo          : '0',";
$str .= "\n"." },            ";
 foreach ($lista as $el) {
  //$arr[$el->get('number')] =
  $e = $el->getData();
    $str .= "\n"." {              ";
    $str .= "\n"."      nombre          : ".json_encode($e['nombre']).",";
    $str .= "\n"."      numero          : '".$e['numero']."',";
    $str .= "\n"."      id              : '".$e['id']."',";
    $str .= "\n"."      video           : '".$e['embed_link']."',";
    $str .= "\n"."      medio           : '".$e['medio']."',";
    $str .= "\n"."      activo          : '".$e['active']."',";
    $str .= "\n"."      comentarios     : ".json_encode(($e['comentarios']==""?"":$e['comentarios'])).",";
    $str .= "\n"."      codigo          : '".$e['codigo']."',";
    $str .= "\n"."      logo            : '".$e['logo']."',";
    $str .= "\n"."      visitas         : '".$e['visitas']."',";
    $str .= "\n"."      ignorar_chk     : '".$e['check']."',";
    if ($el instanceof DtYouTube){
    $str .= "\n"."      yt_nameVideo    : ".json_encode(($e['yt_nameVideo']==""?"":addslashes ($e['yt_nameVideo']))).",";
    $str .= "\n"."      yt_nameChannel  : ".json_encode(($e['yt_nameChannel']==""?"":addslashes ($e['yt_nameChannel']))).",";
    $str .= "\n"."      yt_description  : ".json_encode(($e['yt_description']==""?"":addslashes ($e['yt_description']))).",";
    $str .= "\n"."      yt_logo         : '".($e['yt_logo']==""?$e['logo']:$e['yt_logo'])."',";
    $str .= "\n"."      yt_rating       : '".$e['yt_rating']."',";
    }else{
      if ($el instanceof DtDirectLink){
    //$str .= "\n"."      medio           : '1',";
    $str .= "\n"."      placeHolder     : '".($e['placeHolder']==""?"":$e['placeHolder'])."',";
      }
    }
    $str .= "\n"."      codigo          : '".$e['codigo']."',";
    $str .= "\n"."      tv              : '".($e['tv']==""?"1":0)."',";

    $str .= "\n"." },            ";
 }
 $str .= "\n"." ];            ";

$fichero = 'gente.txt';
// Abre el fichero para obtener el contenido existente
$fichero = "js/grilla.js";
//$actual = file_get_contents($fichero);

echo '<a href="js/grilla.js">Generado correctamente.</a>';


function escapeJavaScriptText($string)
{
    return $string;
    //return str_replace("\n", '\n', str_replace('"', '"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\")));
}


//$data = mb_convert_encoding($str, 'UTF-8', 'OLD-ENCODING');
file_put_contents($fichero, "\xEF\xBB\xBF".  $str);
//file_put_contents($fichero, $str);




//$json = json_encode($arr, JSON_UNESCAPED_UNICODE);

 ?>
