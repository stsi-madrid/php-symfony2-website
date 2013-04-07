<?php
namespace ECL\ArticlesBundle\Form;
      use Symfony\Component\Form\AbstractType;
      use Symfony\Component\Form\FormBuilder;

class ArticleExtendType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('article_text', 'textarea', array('label' => 'Contenido', 'required' => false));
                
    }
    public function getName()
    {
        return 'article_extend_form';
    }
}