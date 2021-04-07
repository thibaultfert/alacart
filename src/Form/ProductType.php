<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('images')
            ->add('region')
            ->add('description')
            ->add('volume')
            ->add('weight')
            ->add('price')
            ->add('type', ChoiceType::class, [
                'placeholder' => 'Choisir un type',
                'choices' => [
                    'vin rouge' => 'red_wine',
                    'vin blanc' => 'white_wine',
                    'vin rosé' => 'rose_wine',
                    'champagne ou bulles' => 'champagne',
                    'jambon' => 'ham',
                    'foie gras' => 'foie_gras',
                    'huile' => 'oil'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'attr' => ['novalidate' => 'novalidate', // comment me to reactivate HTML5 validation
            ] 
        ]);
    }
}
