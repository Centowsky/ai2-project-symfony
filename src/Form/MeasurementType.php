<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'placeholder' => 'Select date',
                ],
                'empty_data' => (new \DateTime())->format('Y-m-d'),
            ])
            ->add('temperature', NumberType::class, [
                'scale' => 1,
                'attr' => [
                    'placeholder' => 'Enter temperature in °C',
                ],
            ])
            ->add('air_humidity', NumberType::class, [
                'scale' => 2,
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                    'placeholder' => 'Enter humidity percentage',
                ],
            ])
            ->add('wind_speed', NumberType::class, [
                'scale' => 2,
                'attr' => [
                    'placeholder' => 'Enter wind speed (km/h)',
                ],
            ])
            ->add('wind_direction', ChoiceType::class, [
                'choices' => [
                    'North' => 'N',
                    'East' => 'E',
                    'South' => 'S',
                    'West' => 'W',
                    'North-West' => 'NW',
                    'North-East' => 'NE',
                    'South-West' => 'SW',
                    'South-East' => 'SE',
                ],
                'placeholder' => 'Select wind direction',
            ])
            ->add('pressure', NumberType::class, [
                'scale' => 1,
                'attr' => [
                    'placeholder' => 'Enter pressure in hPa',
                ],
            ])
            ->add('cloud_cover', ChoiceType::class, [
                'choices' => [
                    'Clear (0%)' => 'Clear',
                    'Few clouds (10%)' => 'Few clouds',
                    'Partly cloudy (30%)' => 'Partly cloudy',
                    'Scattered clouds (40%)' => 'Scattered clouds',
                    'Broken clouds (50%)' => 'Broken clouds',
                    'Mostly cloudy (70%)' => 'Mostly cloudy',
                    'Overcast (100%)' => 'Overcast',
                ],
                'placeholder' => 'Select cloud cover',
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
                'placeholder' => 'Select a location',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
