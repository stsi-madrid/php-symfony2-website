<?php
namespace ECL\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    const ITEMS_PER_PAGE = 11;
    
    public function indexAction($page = null)
    {
        if ($page == 1) {
            return $this->redirect($this->generateURL('ECLHomeBundle_homepage'), 301);
        } else if (substr($page, 0, 6) == 'pagina') {
            return $this->redirect(
            $this->generateUrl(
                'ECLHomeBundle_articles',
                array('page'=>substr($page, 7, 1))
            ),
            301
        );
        }
        $em = $this->getDoctrine()->getEntityManager();
        $articles = $em->getRepository('ECLHomeBundle:Articles')
            ->getArticles(self::ITEMS_PER_PAGE, $page);
        if (empty($articles)) {
            throw new NotFoundHttpException();
        }        
        return $this->render(
            'ECLHomeBundle:Default:index.html.twig',
            array(
                'page'     => $page,
                'articles' => $articles
            )
        );
    }
    
    public function navAction($page = null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $total_num_items = $em->getRepository('ECLHomeBundle:Articles')
            ->getTotalArticlesNum();
        $total_num_pages = ceil($total_num_items/self::ITEMS_PER_PAGE);
        if ($total_num_pages > 1) {
            $nav_array = array(
                'first'     => null,
                'last'      => null,
                'previous'  => null,
                'next'      => null,
                'last_page' => $total_num_pages
            );
            if ($page != null) {
                $nav_array['first'] = true;
                if ($page > 2) {
                    $nav_array['previous'] = $page-1;
                }            
            } else {
                $page = 1;
            }
            $nav_array['current_page'] = $page;
            if ($page != $total_num_pages) {
                $nav_array['last'] = $total_num_pages;
                if (($total_num_pages-$page) > 1) {
                   $nav_array['next'] = $page+1;
                }
            }
            return $this->render(
                'ECLHomeBundle:Default:nav.html.twig',
                array('nav_array' => $nav_array)
            );            
        } else {
            return new Response();
        }
    }    
    
}
