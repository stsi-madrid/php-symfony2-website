<?php
namespace ECL\DefaultBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;

class TextExtension extends Twig_Extension
{
    
    private $date_service;
    
    public function __construct($services)
    {
        $this->date_service = $services['date'];
    }
    
    public function getFilters()
    {
        return array(
            'remove_whitespaces' => new Twig_Filter_Method($this, 'removeWhitespaces'),
            'file_extension'     => new Twig_Filter_Method($this, 'getFileExtension'),
            'long_date'          => new Twig_Filter_Method($this, 'getLongDate'),
            'long_long_date'     => new Twig_Filter_Method($this, 'getLongLongDate'),
            'min_long_date'      => new Twig_Filter_Method($this, 'getMinLongDate'),
        );
    }
    
    public function removeWhitespaces($file_name)
    {
        return str_replace(' ', '%20', $file_name);
    }

    public function getFileExtension($file_name)
    {
        return strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    }
    
    public function getLongDate($date)
    {
        return $this->date_service->almostFullDate($date);
    }
    
    public function getLongLongDate($date)
    {
        return $this->date_service->fullDate($date);
    }
    
    public function getMinLongDate($date)
    {
        return $this->date_service->shortDate($date);
    }
    
    public function getName()
    {
        return 'text_extension';
    }
    
}
