<?php
 class Check{
  public $av;
  private static $instance = NULL;
  private function __construct(){
    $this->av = "iniciado";
  }
  public function getInstance(){
    if (Check::$instance == NULL)
      Check::$instance = new Check();
      return Check::$instance;
  }

  public function check_alive($url, $timeout = 10, $successOn = array(200, 301)) {
    $ch = curl_init($url);
    // Set request options
    curl_setopt_array($ch, array(
      CURLOPT_FOLLOWLOCATION => false,
      CURLOPT_NOBODY => true,
      CURLOPT_TIMEOUT => $timeout,
      CURLOPT_USERAGENT => "page-check/1.0"
    ));
    // Execute request
    curl_exec($ch);
    // Check if an error occurred
    if(curl_errno($ch)) {
      curl_close($ch);
      return false;
    }
    // Get HTTP response code
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    // Page is alive if 200 OK is received
    //return $code;
    return in_array( $code, $successOn );
  }



}




?>
