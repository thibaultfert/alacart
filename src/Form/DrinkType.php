<?php

namespace App\Form;

use App\Entity\Drink;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DrinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('images')
            ->add('region')
            ->add('description')
            ->add('volume')
            ->add('price')
            ->add('type', ChoiceType::class, [
                'placeholder' => 'Choisir un type',
                'choices' => [
                    'vin rouge' => 'red_wine',
                    'vin blanc' => 'white_wine',
                    'vin rosé' => 'rose_wine',
                    'champagne ou bulles' => 'champagne'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Drink::class,
        ]);
    }
}
