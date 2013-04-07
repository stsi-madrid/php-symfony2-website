<?php
namespace ECL\ArticlesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    
    public function indexAction($date, $uri)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $article = $em->getRepository('ECLHomeBundle:Articles')
            ->getFullArticle($date, $uri);
        
        return $this->render(
            'ECLArticlesBundle:Default:index.html.twig',
            array('article' => $article)
        );
    }
    
    public function rssAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $articles = $em->getRepository('ECLHomeBundle:Articles')
            ->getArticles();
        
        return $this->render(
            'ECLArticlesBundle:Rss:index.xml.twig',
            array('articles' => $articles)
        );
    }    
    
}
