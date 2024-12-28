<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ProductionSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numOf', TextType::class, [
                'required' => false,
                'label' => 'N° OF',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('startDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'yyyy-MM-dd',
                'label' => 'Date début',
                'attr' => [
                    'class' => 'form-control datepicker',
                ]
            ])
            ->add('endDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'yyyy-MM-dd',
                'label' => 'Date fin',
                'attr' => [
                    'class' => 'form-control datepicker',
                ]
            ])
            ->add('type', TextType::class, [
                'required' => false,
                'label' => 'Type de production',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('operator', TextType::class, [
                'required' => false,
                'label' => 'Opérateur',
                'attr' => [
                    'class' => 'form-control',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

