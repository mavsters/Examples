<?php
/* USO 

<?php
$api = new GoogleURL('CLAVE_API');  
//ver url acortandola
echo $api->encode('http://www.mavsters.com');
//ver url real
echo $api->decode('http://goo.gl/ID');
?>

*/


class GoogleURL
{
 
 private $apiURL = 'https://www.googleapis.com/urlshortener/v1/url';
 
 function __construct($apiKey)
 {
  //creamos la url de solicitud con nuestra key pública
  $this->apiURL = $this->apiURL . '?key=' . $apiKey;
 }
 
 //convierte una url larga en una corta
 public function encode($url)
 {
  $data = $this->cURL($url, true);
  return isset($data->id) ? $data->id : '' ;
 }
 
 //convierte una url corta en la real (larga)
 public function decode($url)
 {
  $data = $this->cURL($url, false);
  return isset($data->longUrl) ? $data->longUrl : '' ;
 }
 
 //enviamos y recogemos los datos del api de google
 private function cURL($url, $post = true)
 {
  $ch = curl_init();
  if ($post) {
   curl_setopt( $ch, CURLOPT_URL, $this->apiURL );
   curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json') );
   curl_setopt( $ch, CURLOPT_POST, true );
   curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode(array('longUrl' => $url)) );
  }
  else {
   curl_setopt( $ch, CURLOPT_URL, $this->apiURL . '&shortUrl=' . $url );
  }
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
  $json = curl_exec($ch);
  curl_close($ch);
  return (object) json_decode($json);
 }
}
?>