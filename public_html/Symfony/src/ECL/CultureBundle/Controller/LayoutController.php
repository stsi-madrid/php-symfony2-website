<?php
namespace ECL\CultureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller
{

    public function sidebarAction()
    {
        return $this->render('ECLCultureBundle:Layout:sidebar.html.twig');
    }
    
}
