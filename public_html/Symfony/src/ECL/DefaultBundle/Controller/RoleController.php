<?php

namespace ECL\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ECL\DefaultBundle\Entity\Role;
use ECL\DefaultBundle\Form\RoleType;

class RoleController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('ECLDefaultBundle:Role')->findAll();

        return $this->render(
            'ECLDefaultBundle:Role:index.html.twig',
            array('entities' => $entities)
        );
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('ECLDefaultBundle:Role')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }

        return $this->render(
            'ECLDefaultBundle:Role:show.html.twig',
            array('entity'      => $entity)
        );
    }

    public function newAction()
    {
        $entity = new Role();
        $form   = $this->createForm(new RoleType(), $entity);

        return $this->render(
            'ECLDefaultBundle:Role:new.html.twig',
            array(
                'entity' => $entity,
                'form'   => $form->createView()
            )
        );
    }

    public function createAction()
    {
        $entity  = new Role();
        $request = $this->getRequest();
        $form    = $this->createForm(new RoleType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl(
                'ECLDefaultBundle_roles_show',
                array('id' => $entity->getId()))
            );
        }

        return $this->render(
            'ECLDefaultBundle:Role:new.html.twig',
            array(
                'entity' => $entity,
                'form'   => $form->createView()
            )
        );
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('ECLDefaultBundle:Role')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }
        $editForm = $this->createForm(new RoleType(), $entity);

        return $this->render(
            'ECLDefaultBundle:Role:edit.html.twig',
            array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView()
            )
        );
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('ECLDefaultBundle:Role')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }
        $editForm   = $this->createForm(new RoleType(), $entity);
        $request = $this->getRequest();
        $editForm->bindRequest($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ECLDefaultBundle_roles_show', array('id' => $id)));
        }

        return $this->render(
            'ECLDefaultBundle:Role:edit.html.twig',
            array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView()
            )
        );
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('ECLDefaultBundle:Role')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }
        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('ECLDefaultBundle_roles'));
    }

}
