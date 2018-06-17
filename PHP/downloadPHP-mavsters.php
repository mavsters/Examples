<?php

//include_once 'c.DownloadFile.php'; //optional

$DownloadFile = new DownloadFile();
$DownloadFile->start(array(
    "url"         => "http://code.jquery.com/jquery-3.2.1.min.js",
"dirFile"=>"/home/mavster/public_html/XXX",//Change XXX
    "nameNewFile" => "jquery-last.min.js"));

class DownloadFile
{
    //Name File
    protected $dirFile;
    protected $result;
    protected $base;
    protected $root;

    public function __construct($dirMain = "")
    {
        $this->root = "";//Change
        if (isset($dirMain)) {
            $this->dirFile = $dirMain;
        } else {
            $this->dirFile = $this->root;
        }
    }

    public function start($elements = array())
    {
        if (isset($elements['url'])) {
            if (isset($elements['dirFile'])) {
                $this->dirFile = $elements['dirFile'];
            } else {
                if (!isset($this->dirFile)) {
                    $this->dirFile = $this->actualFolder($elements['nameNewFile']);
                }
            }
            $this->dirFile .= "/" . $elements['nameNewFile'];
            $this->base =
            $this->url_get_contents($elements['url']); //Get Content
            $this->print(); //MakeFile
        } else {
            exit("No URL");
        }
    }

    public function url_get_contents($url, $useragent = 'cURL', $headers = false, $follow_redirects = true, $debug = false)
    {
        // initialise the CURL library
        $ch = curl_init();
        // specify the URL to be retrieved
        curl_setopt($ch, CURLOPT_URL, $url);
        // we want to get the contents of the URL and store it in a variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // specify the useragent: this is a required courtesy to site owners
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        // ignore SSL errors
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // return headers as requested
        if ($headers == true) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }
        // only return headers
        if ($headers == 'headers only') {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }
        // follow redirects - note this is disabled by default in most PHP installs from 4.4.4 up
        if ($follow_redirects == true) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        }
        // if debugging, return an array with CURL's debug info and the URL contents
        if ($debug == true) {
            $result['contents'] = curl_exec($ch);
            $result['info']     = curl_getinfo($ch);
        }
        // otherwise just return the contents as a variable
        else {
            $result = curl_exec($ch);
        }
        // free resources
        curl_close($ch);
        // send back the data
        return $result;
    }

    function print() {

        $file = fopen($this->dirFile, "w+");
        //Overwrite the file
        fwrite($file, $this->base); //GetContent
        fclose($file); //End Writes
    }

    protected function actualFolder($nameFile)
    {
        $full_url  = $_SERVER['REQUEST_URI'];
        $url_array = explode("/", $full_url);
        if (end($url_array) === $nameFile || end($url_array) == '') {
            $key = array_search($nameFile, $url_array);
            if (!$key) {
                //if FILE is not present and url ends with a '/'
                $key = count($url_array) - 1;
            }
            $target   = (array_key_exists(($key - 1), $url_array)) ? ($key - 1) : $key;
            $dir_name = $url_array[$target];
        } else {
            $dir_name = end($url_array);
        }
        return $dir_name;
    }
}
