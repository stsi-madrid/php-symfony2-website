<?php
namespace ECL\ArticlesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class ArticleType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add(
                'article_title',
                'text',
                array('label' => 'Título','required' => true)
            )
            ->add(
                'article_summary',
                'textarea',
                array('label' => 'Entrada', 'required' => true)
            )
            ->add(
                'articles_extend',
                new ArticleExtendType(),
                array('label' => 'hy')
            );
    }
    
    public function getName()
    {
        return 'article_form';
    }
    
}
