<?php

namespace ECL\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('ECLContactBundle:Default:index.html.twig');
    }
}
