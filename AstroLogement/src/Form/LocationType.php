<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'attr' => ['class' => 'location-input']
            ])
            ->add('description', null, [
                'attr' => ['class' => 'location-input']
            ])
            ->add('planete', null, [
                'attr' => ['class' => 'location-input']
            ])
            ->add('zone', null, [
                'attr' => ['class' => 'location-input']
            ])
            ->add('maxVoyageurs', null, [
                'attr' => ['class' => 'location-input']
            ])
            ->add('cout', null, [
                'attr' => ['class' => 'location-input']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}

