<?php

namespace TouchMe\FloorPlanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'Eventtitle',
                'label_attr' => array(
                    'class'=> ''
                ),
                'attr' => array(
                    'class'=> 'form-control'
                ),
            ))
            ->add('starttime')
            ->add('endtime')
            ->add('description')
            ->add('branchofstudy')
            ->add('personincharge')
            ->add('location')
            ->add('assets')
            
            ->add('save', 'submit',array(    
                'label' => 'speichern',             
                'attr' => array(
                    'class'=> 'btn btn-lg btn-primary btn-block'
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TouchMe\FloorPlanBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'touchme_floorplanbundle_event';
    }
}