<?php

namespace ECL\LaboralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('ECLLaboralBundle:Default:index.html.twig');
    }
    
    public function conveniosAction()
    {
        return $this->render('ECLLaboralBundle:Default:convenios.html.twig');
    }
    
    public function convenioMetalAction()
    {
        return $this->render('ECLLaboralBundle:Convenios:metal.html.twig');
    }
    
    public function convenioIngenieriaAction()
    {
        return $this->render('ECLLaboralBundle:Convenios:ingeniera_y_oficinas_estudios_tecnicos.html.twig');
    }
    
    public function convenioConsultoriaAction()
    {
        return $this->render('ECLLaboralBundle:Convenios:consultoria.html.twig');
    }
    
    public function convenioDespachosAction()
    {
        return $this->render('ECLLaboralBundle:Convenios:oficinas_y_despachos.html.twig');
    }    
    
}
