<?php
namespace ECL\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SitemapController extends Controller
{
    
    private $em;
    
    public function indexAction()
    {
        $this->em = $this->getDoctrine()->getEntityManager();
        $articles = $this->em->getRepository('ECLHomeBundle:Articles')
            ->getArticles();
        
        return $this->render(
            'ECLHomeBundle:Sitemap:index.xml.twig',
            array(
                'pages'    => $this->getTotalPages(),
                'articles' => $articles
            )
        );        
    }
    
    private function getTotalPages()
    {
        return (int) ceil($this->em->getRepository('ECLHomeBundle:Articles')
            ->getTotalArticlesNum()/DefaultController::ITEMS_PER_PAGE);
    }    
    
}
