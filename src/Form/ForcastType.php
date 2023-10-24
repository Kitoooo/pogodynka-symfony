<?php

namespace App\Form;

use App\Entity\Forcast;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForcastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('temperature')
            ->add('feels_like_temp')
            ->add('humidity')
            ->add('wind_speed')
            ->add('precipation_probability')
            ->add('precipation')
            ->add('atmospheric_pressure')
            ->add('date')
            ->add('location')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forcast::class,
        ]);
    }
}
