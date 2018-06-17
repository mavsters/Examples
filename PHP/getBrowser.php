<?php 
function getBrowsers()
{
    //Agent
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browsers = array("Maxthon", "SeaMonkey", "Vivaldi", "Arora", "Avant Browser", "Beamrise", 'Epiphany', 'Chromium', 'Iceweasel', 'Galeon', 'Microsoft Edge', 'Mozilla Firefox', 'Google Chrome', "Safari", 'iTunes', 'Konqueror', 'Dillo', 'Netscape', 'Midori', 'ELinks', 'Links', 'Lynx', 'w3m');
    $browser = "";

    //Check Browsers
    foreach ($browsers as $key => $value) {
        if (strpos($user_agent, $value) !== false) {
            $browser = $browsers[$key-1];   
            break;
        }
    }
    //Exceptions
    if (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident') !== false) {//IE 11
        $browser = 'Internet Explorer';
    } elseif (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== false) {
        $browser = "Opera";
    }
    //Check 
    if($browser==""){
        $browser = 'No hemos podido detectar su navegador';
    }
    return $browser;
}
?>