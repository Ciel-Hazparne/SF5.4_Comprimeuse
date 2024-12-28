<?php

namespace App\Form;

use App\Entity\Production;
use App\Form\AutreTypeProductionType;
use App\Repository\ProductionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numOf', TextType::class, [
                'required' => true,
                'label' => 'N° OF',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('horoDebut', DateTimeType::class, [
                'required' => true,
                'widget' => 'single_text',
                'html5' => true,
                'label' => 'Date de début',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('horoFin', DateTimeType::class, [
                'required' => true,
                'widget' => 'single_text',
                'html5' => true,
                'label' => 'Date de fin',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('typeProd', ChoiceType::class, [
                'label' => 'Type de production',
                'choices' => [
                    'DOLIPRANE' => 'DOLIPRANE',
                    'EFFERALGAN' => 'EFFERALGAN',
                    'NUROFEN' => 'NUROFEN',
                ]
            ])
            ->add('operateur', TextType::class, [
                'required' => true,
                'label' => 'Opérateur',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('cptFlacon', IntegerType::class, [
                'required' => true,
                'label' => 'Comptage Flacons remplis',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('cptBouchon', IntegerType::class, [
                'required' => true,
                'label' => 'Comptage Bouchons déposés',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('cptPriseRobot', IntegerType::class, [
                'required' => true,
                'label' => 'Comptage Prise Robot',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('cptDeposeRobot', IntegerType::class, [
                'required' => true,
                'label' => 'Comptage Dépose Robot',
                'attr' => [
                    'class' => 'form-control',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Production::class,
        ]);
    }
}
