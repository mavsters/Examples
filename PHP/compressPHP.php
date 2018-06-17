<?php

class JSMinifier
{
    protected $copyOrNo;
    public function __construct()
    {
        $this->copy();
    }
    // Array for locking minification
    protected $lock = array(
        'status' => false,
        'char'   => '',
    );

    // JavaScript minification function
    public function minify($js, $level = 4)
    {
        if ($level <= 0) {
            return $js;
        }
        if ($level >= 1) {
            // Remove single-line code comments
            $js = preg_replace('/^[\t ]*?\/\/.*\s?/m', '', $js);
            // Remove end-of-line code comments
            $js = preg_replace('/([\s;})]+)\/\/.*/m', '\\1', $js);
            // Remove multi-line code comments
            $js = preg_replace('/\/\*[\s\S]*?\*\//', '', $js);
        }
        if ($level >= 2) {
            // Remove whitespace
            $js = preg_replace('/^\s*/m', '', $js);
            // Replace multiple tabs with a single space
            $js = preg_replace('/\t+/m', ' ', $js);
        }
        if ($level >= 3) {
            // Remove newlines
            $js = preg_replace('/[\r\n]+/', '', $js);
        }
        if ($level >= 4) {
            // Split input JavaScript by single and double quotes
            $js_substrings = preg_split('/([\'"])/', $js, -1, PREG_SPLIT_DELIM_CAPTURE);
            // Empty variable for minified JavaScript
            $js = '';
            foreach ($js_substrings as $substring) {
                // Check if substring is split delimiter
                if ($substring === '\'' or $substring === '"') {
                    // If so, check whether minification is unlocked
                    if ($this->lock['status'] === false) {
                        // If so, lock it and set lock character
                        $this->lock['status'] = true;
                        $this->lock['char']   = $substring;
                    } else {
                        // If not, check if substring is lock character
                        if ($substring === $this->lock['char']) {
                            // If so, unlock minification
                            $this->lock['status'] = false;
                            $this->lock['char']   = '';
                        }
                    }
                    // Add substring to minified output
                    $js .= $substring;
                    continue;
                }
                // Minify current substring if minification is unlocked
                if ($this->lock['status'] === false) {
                    // Remove unnecessary semicolons
                    $substring = str_replace(';}', '}', $substring);
                    // Remove spaces round operators
                    $substring = preg_replace('/ *([<>=+\-!\|{(},;&:?]+) */', '\\1', $substring);
                }
                // Add substring to minified output
                $js .= $substring;
            }
        }
        // Get URL add "unminified" URL query
        $unminified_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://';
        $unminified_url .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $unminified_url .= '&mavsters-unminified';
        if ($this->copyOrNo) {
            // Copyright notice and URL to unminified code
            $date      = date("Y");
            $copyright = array(
                '// Copyright (C) ' . $date . ' Mavsters',
                '// Private License, Only Mavsters ' . PHP_EOL,

            );
            return implode(PHP_EOL, $copyright) . trim($js) . PHP_EOL;
        } else {
            $copyright = array();
            return trim($js);
        }
        // Return final minified JavaScript

    }
    public function copy($copyright = true)
    {
        $this->copyOrNo = $copyright;
    }
}


$script = "
$( window ).on( 'load', function() {
    alert('hola Mundo!');
});
";
$level = 4;
$mini           = new JSMinifier();
$javascriptPost = $mini->minify($script, $level);
echo $javascriptPost;

