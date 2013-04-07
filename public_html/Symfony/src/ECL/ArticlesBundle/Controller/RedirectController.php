<?php
namespace ECL\ArticlesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RedirectController extends Controller
{

    public function indexAction($uri)
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        $date = $em->getRepository('ECLHomeBundle:Articles')->getDateByUri($uri);
        return $this->redirect(
            $this->generateUrl(
                'ECLArticlesBundle_homepage',
                array('date'=>$this->get('date')->seoDate($date), 'uri'=>$uri)
            ),
            301
        );
    }

}
