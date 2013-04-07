<?php

namespace ECL\AboutBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('ECLAboutBundle:Default:index.html.twig');
    }
}
