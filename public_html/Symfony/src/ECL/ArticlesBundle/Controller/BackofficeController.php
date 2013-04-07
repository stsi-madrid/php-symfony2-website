<?php
namespace ECL\ArticlesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ECL\HomeBundle\Entity\Articles;
use ECL\HomeBundle\Entity\ArticlesExtend;
use ECL\ArticlesBundle\Form\ArticleType;

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
        $session = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getEntityManager();
    
        return $this->render(
            'ECLArticlesBundle:Backoffice:index.html.twig',
            array('articles' => $em->getRepository('ECLHomeBundle:Articles')
                                ->getArticles(null, null, $session->getId()))
        );
    }
    
    public function editarAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('ECLHomeBundle:Articles')->find($id);
        $edit_form = $this->createForm(new ArticleType(), $entity);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $edit_form->bindRequest($request);
            if ($edit_form->isValid()) {
                if ($this->hasRoleAdmin()) {
                    $entity->setUserId($request->get('users'));
                }
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateURL('ECLArticlesBundle_backoffice_articles'));
            }
        }
        
        return $this->render(
            'ECLArticlesBundle:Backoffice:editar.html.twig',
            array(
                'role_admin' => $this->hasRoleAdmin(),
                'users'      => $em->getRepository('ECLDefaultBundle:User')->getChildren(),
                'article'    => $entity,
                'form'       => $edit_form->createView(),
                'article_id' => $id
            )
        );        
    }
    
    public function borrarAction($id, $action = null)
    {
        if ($action === 'yes') {
            $em = $this->getDoctrine()->getEntityManager();
            $item = $em->getRepository('ECLHomeBundle:Articles')
                ->findOneBy(array('id' => $id));
            $em->remove($item);
            $em->flush();

            return $this->redirect($this->generateURL('ECLArticlesBundle_backoffice_articles'));
        } elseif ($action === 'no') {
            return $this->redirect($this->generateURL('ECLArticlesBundle_backoffice_articles'));
        }

        return $this->render('ECLArticlesBundle:Backoffice:borrar.html.twig');
    }
    
    public function publicarAction ()
    {
        $session = $this->get('security.context')->getToken()->getUser();
        $request = $this->getRequest();
        $article = new Articles();
        $article->setUserId($session->getId());
        $articles_extend = new ArticlesExtend();
        $article ->setArticlesExtend($articles_extend);
        $form = $this->createForm(new ArticleType(), $article);
        if($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $articles_extend ->setArticle($article);
                $form_values = $request->get('article_form');
                $article->setArticleUri($this->get('seo')
                    ->getShortCleanUrl($form_values['article_title']));
                $em->persist($article);
                $em->persist($articles_extend);
                $em->flush();
                
                return $this->redirect($this->generateURL('ECLArticlesBundle_backoffice_articles'));
            }
        }
        
        return $this->render(
            'ECLArticlesBundle:Backoffice:publicar.html.twig',
            array('form' => $form->createView())
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
