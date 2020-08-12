<?php

namespace App\Form;

use App\Entity\saison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaisonFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('startdate', DateType::class, [
                                'label'=>'Date début',
                                'required' => false,
                                'html5' => false,
                                'attr' => ['class' => 'form-control js-datepicker'],
                                'widget' => 'single_text'])

                ->add('enddate', DateType::class, [
                            'label'=>'Date Fin',
                            'required' => false,
                            'html5' => false,
                            'attr' => ['class' => 'js-datepicker'],
                            'widget' => 'single_text']);
    }

    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => saison::class,]);
    }

}