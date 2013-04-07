<?php
namespace ECL\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Finder;
use Symfony\Component\HttpKernel\Util\Filesystem;

class FilesController extends Controller
{
    
    public function getFilesNameArray($date_service)
    {
        $path = $_SERVER['DOCUMENT_ROOT'].$this->getFilesFolder();
        $files = array();
        $ordered_files = array();
        $order_months_array = $date_service->getMonthNameArray();
        $years = Finder\Finder::create()
                 ->directories()
                 ->depth(0)
                 ->in($path);
        foreach ($years as $year) {
            $year_num = $year->getFilename();
            $files[$year_num] = array ();
            $months = Finder\Finder::create()
                 ->directories()
                 ->depth(0)
                 ->in($path.$year_num);
            foreach ($months as $month) {
                $month_name = $month->getFilename();
                $files[$year_num][$month_name] = array ();
                $docs = Finder\Finder::create()
                        ->files()
                        ->depth(0)
                        ->in($path.$year_num.'/'.$month_name);
                foreach ($docs as $doc) {
                    $files[$year_num][$month_name][] = $doc->getFilename();
                }
            }
            foreach ($order_months_array as $order_months_name) {
                if (isset($files[$year_num][$order_months_name])) {
                    $ordered_files[$year_num][$order_months_name] = 
                    $files[$year_num][$order_months_name];
                }
            }
        }      

        return $ordered_files;
    }
    
    public function removeAction ()
    {
        $request = $this->getRequest();
        if ($request->getMethod() === 'POST') {
            $file_system = new Filesystem;
            $file_system->remove($_SERVER['DOCUMENT_ROOT'].$request->get('input'));
            $path = explode('/', $request->get('input'));
            array_pop($path);
            $dir_path = $_SERVER['DOCUMENT_ROOT'].implode('/', $path);
            if ($this->isEmptyFolder($dir_path)) {
                $file_system->remove($dir_path);
            }

            return new Response(null);
        }   
    }

    public function uploadAction ()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest() && $request->getMethod() === 'POST') {
            if (isset ($_SERVER['HTTP_X_FILENAME'])) {
                $date = $this->get('date');
                $month_name = $date->getMonthName();
                $year = $date->getYearNum();
                $path_to_year = $_SERVER['DOCUMENT_ROOT'].$this->getFilesFolder().$year;
                $path = $path_to_year.'/'.$month_name;
                $file_system = new Filesystem;
                if (!is_dir($path_to_year)) {
                    $file_system->mkdir($path_to_year);
                }                
                if (!is_dir($path)) {
                    $file_system->mkdir($path);
                }
                $input_file_name = $_SERVER['HTTP_X_FILENAME'];
                $file_extension = self::getFileExtension($input_file_name);
                $file_name = $this->get('seo')->getCleanString(
                    self::getFileName($input_file_name)
                );
                file_put_contents($path.'/'.$file_name.'.'.$file_extension,
                file_get_contents('php://input'));
                
                return new Response (
                    json_encode(
                        array(
                            'month_name'     => $month_name,
                            'file_name'      => $file_name,
                            'file_extension' => $file_extension
                        )
                    )
                );
            }
        }
    }
    
    public function indexAction()
    {
        return $this->render(
            'ECLDefaultBundle:Files:index.html.twig',
           array(
               'url'   => $this->getFilesFolder(),
               'files' => $this->getFilesNameArray($this->get('date'))
            )
        );
    }
    
    private static function getFileName($file_name)
    {
        return pathinfo($file_name, PATHINFO_FILENAME);
    }
    
    private static function getFileExtension($file_name)
    {
        return strtolower(pathinfo ($file_name, PATHINFO_EXTENSION));
    }
    
    private function getFilesFolder()
    {
        $session = $this->get('security.context')->getToken()->getUser();
        
        return '/web/bundles/ecldefault/documentos/'.$session->getId().'/';
    }
    
    private function isEmptyFolder($dir_path)
    {
        $files = scandir($dir_path);
        $trash_elements_num = 0;
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                ++$trash_elements_num;
            }
        }
        
        return !(bool) (count($files) - $trash_elements_num);
    }
            
}
