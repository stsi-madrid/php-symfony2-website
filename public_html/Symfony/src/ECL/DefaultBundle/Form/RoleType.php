<?php

namespace ECL\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                array('label' => 'Nombre:','required' => true)
            );
    }

    public function getName()
    {
        return 'ecl_defaultbundle_roletype';
    }
}
