<?php
namespace ECL\SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller
{

    public function sidebarAction()
    {
        return $this->render('ECLSocialBundle:Layout:sidebar.html.twig');
    }
    
}
