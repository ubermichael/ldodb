<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BibliographicTermsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        $builder->add('bibliographicTerm', null, array(
            'label' => 'Bibliographic Term',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
                $builder->add('useForFormat', ChoiceType::class, array(
            'label' => 'Use For Format',
            'expanded' => true,
            'multiple' => false,
            'choices' => array(
                'Yes' => true,
                'No' => false,
                'Unknown' => null,
                ),
            'required' => false,
            'placeholder' => false,
            'attr' => array(
                'help_block' => '',
            ),
            
        ));
                $builder->add('useForPhotographs', ChoiceType::class, array(
            'label' => 'Use For Photographs',
            'expanded' => true,
            'multiple' => false,
            'choices' => array(
                'Yes' => true,
                'No' => false,
                'Unknown' => null,
                ),
            'required' => false,
            'placeholder' => false,
            'attr' => array(
                'help_block' => '',
            ),
            
        ));
                $builder->add('useForIllustrations', ChoiceType::class, array(
            'label' => 'Use For Illustrations',
            'expanded' => true,
            'multiple' => false,
            'choices' => array(
                'Yes' => true,
                'No' => false,
                'Unknown' => null,
                ),
            'required' => false,
            'placeholder' => false,
            'attr' => array(
                'help_block' => '',
            ),
            
        ));
                
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BibliographicTerms'
        ));
    }
}
