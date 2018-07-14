<?php

class Yapi {
        private $key = 'AIzaSyBkYJmXrNPc9lpmMLSEXXzna7UQ1G7t52c';
        public $jso = 'ind';
        public $chid = 'ind';
        public $vidid = 'ind';
        public $c5n = 'UCf_uRkSNbPDBToWyLnnmHHw';
        public $video = 'M_LVav_dMcc';
        private static $instance = NULL;

        private function __construct(){}

        public static function getInstance(){
          if (Yapi::$instance == NULL){
            Yapi::$instance = new Yapi();
          }
            return Yapi::$instance;
        }


        function getChannelLogo($channelId,$quality=1){
          $json =  file_get_contents('https://www.googleapis.com/youtube/v3/channels?part=snippet&id='.$channelId.'&fields=items%2Fsnippet%2Fthumbnails&key='.$this->key);
          $obj = json_decode($json);
          $url = "";
          if ($obj != NULL)
            switch ($quality) {
              case 0:
                    $url = $obj->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'default'}->{'url'};
                break;
              case 1:
                  $url = $obj->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'medium'}->{'url'};
                break;
              case 2:
                  $url = $obj->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'high'}->{'url'};
                break;
              default:
                  $url = "null.jpg";
                break;
            }
          return $url;
        }


        function getChannelDescripcion($channelId){
          $json = file_get_contents('https://www.googleapis.com/youtube/v3/search?part=snippet&channelId='.$channelId.'&eventType=live&type=video&key='.$this->key);
          $obj = json_decode($json);
          $resultado;

          //->{'code'}==400?"T":"F";
          if ($obj != NULL && sizeof($obj->items) > 0){
            $resultado = $obj->items[0]->snippet->channelTitle;
            $resultado .= " - " . $obj->items[0]->snippet->description;
            $resultado .= " - " . $obj->items[0]->snippet->title;
          }else{
            $resultado = "a";
          }
          return $resultado;
        }

        function getVideoDescripcion($videoId){
          $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.$videoId.'&key='.$this->key);
          $obj = json_decode($json);
          $resultado;
          if ($obj != NULL && sizeof($obj->items) > 0){
            $resultado = $obj->items[0]->snippet->channelTitle;
            $resultado .= " - " . $obj->items[0]->snippet->description;
            $resultado .= " - " . $obj->items[0]->snippet->title;
          }else{
            $resultado = "a";
          }
          return $resultado;
        }

        function getVideoLiveIdFromchannelId($channelId){
          $json = file_get_contents('https://www.googleapis.com/youtube/v3/search?part=snippet&channelId='.$channelId.'&eventType=live&type=video&key='.$this->key);
          $obj = json_decode($json);
          $resultado;
          if ($obj != NULL && sizeof($obj->items) > 0){
            $resultado = $obj->items[0]->id->videoId;
          }else{
            $resultado = NULL;
          }
          return $resultado;
        }

        function getChannelIdFromVideoId($videoId) {
          $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.$videoId.'&key='.$this->key);
          $obj = json_decode($json);
          $resultado;
          if ($obj != NULL && sizeof($obj->items) > 0){
            $resultado = $obj->items[0]->snippet->channelId;
          }else{
            $resultado = NULL;
          }
          return $resultado;
        }


        function getChannelTitleFromVideoId($videoId) {
          $json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.$videoId.'&key='.$this->key);
          $obj = json_decode($json);
          $resultado;
          if ($obj != NULL && sizeof($obj->items) > 0){
            $resultado = $obj->items[0]->snippet->channelTitle;
          }else{
            $resultado = NULL;
          }
          return $resultado;
        }


        function getChannelIdFromChannelTitle($user){
          $json = file_get_contents('https://www.googleapis.com/youtube/v3/channels?key='.$this->key.'&forUsername='.$user.'&part=id');
          $obj = json_decode($json);
          $resultado;
          if ($obj != NULL && sizeof($obj->items) > 0){
            $resultado = $obj->items[0]->id;
          }else{
            $resultado = NULL;
          }
          return $resultado;
        }


        function getVideoIdFromChannelId($chId){
          $json = file_get_contents('https://www.googleapis.com/youtube/v3/search?key='.$this->key.'&channelId='.$chId.'&part=snippet,id&order=date&maxResults=1');
          $obj = json_decode($json);
          $resultado;
          if ($obj != NULL && sizeof($obj->items) > 0){
            $resultado = $obj->items[0]->id->videoId;
          }else{
            $resultado = NULL;
          }
          return $resultado;
        }


        function resp($valor){
          return '<input type="text"'
          .'value='.$valor
          .' readonly '
          .' onClick="setSelectionRange(0, this.value.length );"'

          .'></input>'
          .'<br>'
          .'<br>'
          ;
        }


              function mostrarIDatosDeUsuario($chTitle){
                echo "El dato a buscar es ".$chTitle;
                $channelId;
                $videoId;
                $res = "No enconrtado.";
                if ($chTitle != ""){
                    $channelId = $this->getChannelIdFromChannelTitle($chTitle);
                    if ($channelId != NULL){
                      $videoId = $this->getVideoLiveIdFromchannelId($channelId);
                      if ($videoId != NULL){
                        $res = "Encontrado: ChannelID: ".$this->resp($channelId)." videoId: ".$this->resp($videoId);
                      }else{
                        $res = "Encontrado: ChannelID: ".$this->resp($channelId)." No hay video en vivo.";
                      }
                    }
                }
                return $res;
            }


            function getFromvidId($vidId){
                echo "El dato a buscar es: ". $vidId;
                $chId;
                $chTitle;
                $res = "No encontrado.";
                if ($vidId != ""){
                  $chId = $this->getChannelIdFromVideoId($vidId);
                  $chTitle = $this->getChannelTitleFromVideoId($vidId);
                }
                return $chId."  ".$chTitle;
            }


            function getFromchId($chId){
              echo "El dato a buscar es: ".$chId;
              $vidId;
              $chTitle;
              if ($chId != ""){
                $vidId = $this->getVideoLiveIdFromchannelId($chId);
                $idvideo = $this->getVideoIdFromChannelId($chId);
                if ($idvideo != NULL){
                  $chTitle = $this->getChannelTitleFromVideoId($idvideo);
                }
              }
              return $vidId." ".$idvideo." ".$chTitle;
            }

            function getFromchTitle($chTitle){
              echo "El dato a buscar es: ". $chTitle;
              $chId;
              $vidId;
              if ($chTitle != ""){
                $chId = $this->getChannelIdFromChannelTitle($chTitle);
                if ($chId != NULL){
                  $vidId = $this->getVideoLiveIdFromchannelId($chId);
                }
              }
              return $chId." ".$vidId;
            }


            function getCountViewers($videoId){
            	$json = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=liveStreamingDetails&id='.$videoId.'&key='.$this->key);
              $obj = json_decode($json);
              $resultado;
              if ($obj != NULL && sizeof($obj->items) > 0){
                $resultado = $obj->items[0]->liveStreamingDetails->concurrentViewers;
            	}else{
                $resultado = NULL;
              }
            	return $resultado;
            }

      public function toString(){
        return $this->getCountViewers('vnVeVWYMLIs');
      }




        //echo  $obj['access_token'];

        //echo $json;

}
 ?>
