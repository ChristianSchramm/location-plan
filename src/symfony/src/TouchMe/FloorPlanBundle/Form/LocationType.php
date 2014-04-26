<?php

namespace TouchMe\FloorPlanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class LocationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', 'text', array(
                'label' => 'Raumnummer',
                'label_attr' => array(
                    'class'=> ''
                ),
                'attr' => array(
                    'class'=> 'form-control'
                ),
            ))
            ->add('type', 'choice', array(
                'label' => 'Raumtyp',
                'choices'   => array(
                    'Bibliothek' => 'Bibliothek',
                    'Computerraum'   => 'Computerraum',
                    'Holztechnik' => 'Holztechnik',
                    'Hausmeister'   => 'Hausmeister',
                    'Hörsaal'   => 'Hörsaal',
                    'Labor'   => 'Labor',
                    'Lagerraum'   => 'Lagerraum',
                    'Mensa'   => 'Mensa',
                    'Sanitär'   => 'Sanitär',
                    'Schnittraum'   => 'Schnittraum',
                    'Seminarraum'   => 'Seminarraum',
                    'Sonstiges' => 'Sonstiges',
                    'Sprachlabor'   => 'Sprachlabor',
                    'Tonstudio' => 'Tonstudio',

                ),
                'label_attr' => array(
                    'class'=> ''
                ),
                'attr' => array(
                    'class'=> 'form-control'
                ),
            ))
            ->add('description', 'textarea',array(  
                'label' => 'Beschreibung',
                'required' => false,               
                'label_attr' => array(
                    'class'=> ''
                ),
                'attr' => array(
                    'class'=> 'form-control'
                ),
            ))
            ->add('visible', 'checkbox',array(  
                'label' => 'Sichtbar bei Veranstaltungen',
                'required' => false,               
                'label_attr' => array(
                    'class'=> ''
                ),
                'attr' => array(
                    'class'=> 'form-control'
                ),
            ))
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
            'data_class' => 'TouchMe\FloorPlanBundle\Entity\Location'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'touchme_floorplanbundle_location';
    }
}
