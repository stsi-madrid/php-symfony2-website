<?php
namespace ECL\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add(
                'username',
                'text',
                array('label' => 'Nombre:', 'required' => true)
            )
            ->add(
                'password',
                'password',
                array('label' => 'Contraseña:', 'required' => true)
            )
            ->add(
                'email',
                'text',
                array('label' => 'email:', 'required' => false)
            )
            ->add(
                'alias',
                'text',
                array('label' => 'alias:', 'required' => false)
            )
            ->add('user_roles')
        ;
    }

    public function getName()
    {
        return 'mdw_blogbundle_usertype';
    }
    
}
