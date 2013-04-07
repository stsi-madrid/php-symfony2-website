<?php
namespace ECL\DefaultBundle\Helpers\date;

class Date
{

    public  $date;

    function __construct()
    {
        // Para saber la configuración instalada:
        // echo shell_exec('locale -a');exit;
        $this->_getLocale();
    }
    
    public function getYearNum($date = NULL)
    {
        $format = 'Y';
        if ($date) {
            return date($format, strtotime($date));
        } else {
            return date($format);
        }           
    }
    
    public function getMonthName($date = NULL)
    {
        $format = '%B';
        if ($date) {
            $name = strftime($format, strtotime($date));
        } else {
            $name = strftime($format);
        }
        
        return self::getSpanishMonthName($name);
    }
    
    public function getMonthNameArray()
    {
        $format = '%B';
        $month_name_array = array();
        for ($i = 1; $i <= 12; ++$i) {
            $month_name_array[] = self::getSpanishMonthName(strftime($format, strtotime ('2000-'.$i)));
        }
        
        return $month_name_array;
    }

    public function timeStamp($date = NULL, $hour = NULL)
    {
        if ($date) {
            $this->date = $date;
            $this->_convertDate();
            if ($hour) $this->date = $this->date.' '.$hour;

            return date('Y-m-d H:i:s', strtotime($this->date));
        } else {
            return date('Y-m-d H:i:s');
        }
    }

    public function timeStamp_modify($date = NULL, $hour = NULL)
    {
        if ($date) {
            $this->date = $date;
            $this->_convertDate();
            if ($hour) $this->date = $this->date.' '.$hour;

            return date ('Y-m-d_H-i-s', strtotime ($this->date));
        } else {
            return  date ('Y-m-d_H-i-s');
        }
    }

    public function tinyDate($date)
    {
        return strftime('%d/%m/%y', strtotime ($date));
    }
    
    public function seoDate($date)
    {
        return strftime('%d-%m-%Y', strtotime ($date));
    }

    public function shortDate($date)
    {
        return strftime('%e/%m/%y | %H:%M', strtotime($date));
    }

    public function fullDate($date = NULL)
    {
        $format = '%A %e de %B del %Y a las %H:%M';
        if ($date) {
            return strftime($format, strtotime ($date));
        } else {
            return strftime($format);
        }
    }

    public function almostFullDate($date)
    {
        return strftime(self::getSpanishDayName(strftime('%A', strtotime($date))).' %e de '.self::getSpanishMonthName(strftime('%B', strtotime($date))).' del %Y', strtotime($date));
    }

    /* Comprueba si la fecha existe y tiene alguno de los siguientes formatos:
     dd/mm/yy
     dd.mm.yy
     dd-mm-yy
     dd mm yy
     */
    public function checkDate()
    {
        $this->date = trim ($this->date);
        $date = $this->date;

        if (strlen ($this->date) != 8) {
            $check = FALSE;
        } else {
            $this->_convertDate();
            $stamp = strtotime ($this->date);
            if (!is_numeric ($stamp)) {
                $check = FALSE;
            } else {
                if (is_numeric(substr($date, 2, 1)) || is_numeric(substr($date, 5, 1))) {
                    $check = FALSE;
                } else {
                    $day   = substr ($date, 0, 2);
                    $month = substr ($date, 3, 2);
                    $year  = substr ($date, 6, 2);
                    $check = checkdate ($month, $day, $year);
                }
            }
        }

        return ($check) ? 1 : 0;
    }

    public function secondsDiff ($timestamp_1, $timestamp_2 = NULL)
    {
        if ($timestamp_2 === NULL) {
            $timestamp_2 = $this->timeStamp();
        }
        $date_1 = strtotime ($timestamp_1);
        $date_2 = strtotime ($timestamp_2);
        $seconds_diff = $date_2 - $date_1;

        return $seconds_diff;
    }

    public function daysDiff ($timestamp_1, $timestamp_2 = NULL)
    {
        $seconds_diff = $this->secondsDiff ($timestamp_1, $timestamp_2);
        $days_diff = floor ($seconds_diff / (60 * 60 * 24));

        return (int) $days_diff;
    }

    public function addDays ($days, $timestamp = NULL)
    {
        if ($timestamp === NULL) {
            $timestamp = $this-> timeStamp();
        }

        return date ('Y-m-d H:i:s', strtotime ($timestamp.' +'.$days.' days'));
    }
    
    public static function getSpanishMonthName($month)
    {
        switch ($month) {
            case 'January':
                $name = 'enero';
                break;
            case 'Frebruary':
                $name = 'febrero';
                break;
            case 'March':
                $name = 'marzo';
                break;
            case 'April':
                $name = 'abril';
                break;
            case 'May':
                $name = 'mayo';
                break;
            case 'June':
                $name = 'junio';
                break;
            case 'July':
                $name = 'julio';
                break;
            case 'August':
                $name = 'agosto';
                break;
            case 'September':
                $name = 'septiembre';
                break;
            case 'October':
                $name = 'octubre';
                break;
            case 'November':
                $name = 'noviembre';
                break;
            case 'December':
                $name = 'diciembre';
                break;
            default:
                $name = $month;
                break;
        }
        
        return $name;
    }
    
    public static function getSpanishDayName($day)
    {
        switch ($day) {
            case 'Monday':
                $name = 'lunes';
                break;
            case 'Tuesday':
                $name = 'martes';
                break;
            case 'Wednesday':
                $name = 'miércoles';
                break;
            case 'Thursday':
                $name = 'jueves';
                break;
            case 'Friday':
                $name = 'viernes';
                break;
            case 'Saturday':
                $name = 'sábado';
                break;
            case 'Sunday':
                $name = 'domingo';
                break;
            default:
                $name = $day;
                break;
        }
        
        return $name;
    }

    /* --------------- Métodos auxiliares --------------- */
    
    private function _getLocale()
    {
        setlocale(LC_ALL, 'C'); // <--- necesario para evitar problemas "cache"
        setlocale(LC_ALL, 'es_ES.utf8');
    }
    
    /* 
     * Convierte la fecha dada a formato dd.mm.yy
     * Formatos de fechas admitidos:
     * dd/mm/yy
     * dd.mm.yy
     * dd-mm-yy
     * dd mm yy
    */
    private function _convertDate()
    {
        $string = $this->date;
        $this->date = substr($string, 6, 2).'-'.substr($string, 3, 2).'-'.substr($string, 0, 2);
    }

}