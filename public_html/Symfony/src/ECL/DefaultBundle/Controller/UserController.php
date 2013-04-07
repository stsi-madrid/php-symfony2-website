<?php
namespace ECL\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ECL\DefaultBundle\Entity\User;
use Symfony\Component\HttpKernel\Util\Filesystem;
use ECL\DefaultBundle\Form\UserType;
use ECL\DefaultBundle\Form\UserProfileType;

class UserController extends Controller
{
    
    const FILES_FOLDER = '/web/bundles/ecldefault/documentos/';
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $session = $this->get('security.context')->getToken()->getUser();
        return $this->render(
            'ECLDefaultBundle:User:index.html.twig',
           array(
               'users' => $em->getRepository('ECLDefaultBundle:User')->getChildren($session->getId()),
               'roles' => $em->getRepository('ECLDefaultBundle:Role')->getById(),
               'relationship' => $em->getRepository('ECLDefaultBundle:UserRoleRelationship')->findAll()
            )
        );
    }

    public function newAction()
    {
        $entity = new User;
        $form   = $this->createForm(new UserType(), $entity);

        return $this->render(
            'ECLDefaultBundle:User:new.html.twig',
            array(
                'entity' => $entity,
                'form'   => $form->createView()
            )
        );
    }
    
    public function createAction()
    {
        $entity  = new User;
        $request = $this->getRequest();
        $form    = $this->createForm(new UserType(), $entity);
        $form->bindRequest($request);
        if ($form->isValid()) {
            $this->setSecurePassword($entity);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $file_system = new Filesystem;
            $file_system->mkdir($_SERVER['DOCUMENT_ROOT'].self::FILES_FOLDER.$entity->getId());
            
            return $this->redirect(
                $this->generateUrl('ECLDefaultBundle_users',
                array('id' => $entity->getId()))
            );
        }

        return $this->render(
            'ECLDefaultBundle:User:new.html.twig',
            array(
                'entity' => $entity,
                'form'   => $form->createView()
            )
        );
    }
    
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('ECLDefaultBundle:User')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }
        $editForm = $this->createForm(new UserType(), $entity);

        return $this->render(
            'ECLDefaultBundle:User:edit.html.twig',
            array(
                'entity'    => $entity,
                'edit_form' => $editForm->createView(),
                'articles'  => $em->getRepository('ECLHomeBundle:Articles')
                    ->getArticles(null, null, $id)
            )
        );
    }
    
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('ECLDefaultBundle:User')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $editForm = $this->createForm(new UserType(), $entity);
        $request = $this->getRequest();
        $current_pass = $entity->getPassword();
        $editForm->bindRequest($request);
        if ($editForm->isValid()) {
            if ($current_pass != $entity->getPassword()) {
                $this->setSecurePassword($entity);
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ECLDefaultBundle_users', array('id' => $id)));
        }

        return $this->render(
            'ECLDefaultBundle:User:edit.html.twig',
            array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView()
            )
        );
    }    
    
    private function setSecurePassword(&$entity)
    {
        $entity->setSalt(md5(time()));
        $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
        $entity->setPassword($password);
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('ECLDefaultBundle:User')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }
        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('ECLDefaultBundle_users'));
    }
    
    public function updateProfileAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('ECLDefaultBundle:User')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $editForm = $this->createForm(new UserProfileType(), $entity);
        $request = $this->getRequest();
        $current_pass = $entity->getPassword();
        $editForm->bindRequest($request);
        if ($editForm->isValid()) {
            if ($current_pass != $entity->getPassword()) {
                $this->setSecurePassword($entity);
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ECLDefaultBundle_users'));
        }

        return $this->render(
            'ECLDefaultBundle:User:edit.html.twig',
            array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView()
            )
        );
    }    
    
    public function profileAction()
    {
        $request = $this->getRequest();
        $session = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('ECLDefaultBundle:User')->find($session->getId());
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }
        $editForm = $this->createForm(new UserProfileType(), $entity);
        
        return $this->render(
            'ECLDefaultBundle:User:profile.html.twig',
            array(
                'entity'    => $entity,
                'edit_form' => $editForm->createView()
            )
        );
    }

}
