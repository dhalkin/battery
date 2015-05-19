<?php

namespace My\BatteryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BatteryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', array(
                'placeholder' => 'Choose a type',
                'choices' => array('AA' => 'AA', 'AAA' => 'AAA'),
                'required' => true))
            ->add('count', 'integer', array('required' => true))
            ->add('name', 'text', array('required' => false));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'My\BatteryBundle\Entity\Battery'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'my_batterybundle_battery';
    }
}
