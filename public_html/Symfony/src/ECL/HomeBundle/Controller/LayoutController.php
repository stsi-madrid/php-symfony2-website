<?php
namespace ECL\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller
{

    public function sidebarAction()
    {
        return $this->render('ECLHomeBundle:Layout:sidebar.html.twig');
    }
    
    public function footerAction()
    {
        $xml = simplexml_load_file('http://sovmadrid.cnt.es/rss.xml');
        
        return $this->render(
            'ECLHomeBundle:Layout:footer.html.twig',
            array(
                //'feeds' => array()
                'feeds' => $xml->channel->item
            )
        );
    }
    
}
