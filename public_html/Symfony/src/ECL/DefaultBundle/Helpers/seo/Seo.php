<?php
namespace ECL\DefaultBundle\Helpers\seo;

class Seo
{
    
    public function getCleanString ($string)
    {
        $string = strtolower ($string);
        $find = array ('á', 'é', 'í', 'ó', 'ú', 'ñ');
        $repl = array ('a', 'e', 'i', 'o', 'u', 'n');
        $string = str_replace ($find, $repl, $string);
        $string = trim ($string);
        $find = array (' ', '&', '\r\n', '\n', '+');
        $string = str_replace ($find, '-', $string);
        $find = array ('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
        $repl = array ('', '-', '');
        $string = preg_replace ($find, $repl, $string);
        	
        return $string;
    }
    
    public function getShortCleanUrl ($string)
    {
        $string = $this->getCleanString ($string);
        if (str_word_count ($string) > 8)
        {
            $find = array(' que ',' el ',' un ',' uno ',' una ',' unos ',
            ' unas ',' a ',' al ',' ante ',' con ',' de ',' del ',' en ',
            ' entre ',' y ',' la ',' lo ',' los ',' las ',' hacia ',' para ',
            ' por ',' se ',' sobre ',' tras ');
            $string = str_replace ($find, ' ', $string);
        }
        	
        return $string;
    }    

}