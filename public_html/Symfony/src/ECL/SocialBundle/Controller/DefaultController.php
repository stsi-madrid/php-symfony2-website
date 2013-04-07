<?php
namespace ECL\SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('ECLSocialBundle:Default:index.html.twig');
    }
    
    public function softwareLibreAction()
    {
        return $this->render('ECLSocialBundle:Software_Libre:index.html.twig');
    }
    
    public function softwareLibreJornadasIAction()
    {
        return $this->render('ECLSocialBundle:Software_Libre:jornadas_i.html.twig');
    }
    
    public function softwareLibreAnarquismoyComunidadAction()
    {
        return $this->render('ECLSocialBundle:Software_Libre:anarquismo_y_comunidad.html.twig');
    }
    
    public function softwareLibreHitosConocimientoAction()
    {
        return $this->render('ECLSocialBundle:Software_Libre:hitos_conocimiento.html.twig');
    }    
    
}
