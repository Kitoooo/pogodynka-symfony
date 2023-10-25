<?php

namespace App\Form;


use App\Entity\Forcast;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForcastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temperature', NumberType::class,[
                'html5'=>true,
            ])
            ->add('feels_like_temp', NumberType::class,[
                'html5'=>true,
            ])
            ->add('humidity', NumberType::class,[
                'html5'=>true,
            ])
            ->add('wind_speed', NumberType::class,[
                'html5'=>true,
            ])
            ->add('precipation_probability', NumberType::class,[
                'html5'=>true,
            ])
            ->add('precipation', NumberType::class,[
                'html5'=>true,
                'required'=>false,
            ])
            ->add('atmospheric_pressure', NumberType::class,[
                'html5'=>true,
            ])
            ->add('date', DateType::class)
            ->add('location', EntityType::class, [
                'class' => 'App\Entity\Location',
                'choice_label' => 'city',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forcast::class,
        ]);
    }
}
