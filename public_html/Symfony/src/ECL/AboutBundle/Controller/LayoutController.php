<?php
namespace ECL\AboutBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller
{

    public function sidebarAction()
    {
        return $this->render('ECLAboutBundle:Layout:sidebar.html.twig');
    }
    
}
