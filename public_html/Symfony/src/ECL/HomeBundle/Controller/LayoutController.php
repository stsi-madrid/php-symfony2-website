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
        $xml = simplexml_load_file('http://madrid.cnt.es/rss.php');
        $items = array();

        for ($i = 0; $i < 9; $i++) {
            $items[] = $xml->channel->item[$i];
        }

        return $this->render(
            'ECLHomeBundle:Layout:footer.html.twig',
            array(
                //'feeds' => array()
                'feeds' => $items
            )
        );
    }
    
}
