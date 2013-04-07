<?php
namespace ECL\LaboralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller
{

    public function sidebarAction()
    {
        return $this->render('ECLLaboralBundle:Layout:sidebar.html.twig');
    }
    
}
