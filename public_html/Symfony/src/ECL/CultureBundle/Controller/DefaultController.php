<?php
namespace ECL\CultureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('ECLCultureBundle:Default:index.html.twig');
    }
    
}
