<?php
namespace ECL\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BackofficeCOntroller
 *
 * @author eduardo
 */
class BackofficeCOntroller extends Controller
{
    
    public function indexAction()
    {
        return $this->render(
            'ECLHomeBundle:Backoffice:index.html.twig',
            array('role_admin' => $this->hasRoleAdmin())
        );
    }
    
    private function hasRoleAdmin()
    {
        $session = $this->get('security.context')->getToken()->getUser();
        foreach ($session->getRoles() as $item){
            if ($item->getName() == 'ROLE_ADMIN') {
                $access = true;
                break;
            }
        }
        
        return isset($access);
    }
    
}
