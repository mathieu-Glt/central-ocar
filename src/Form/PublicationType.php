<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre de l'annonce",
                'attr' => [
                    'placeholder' => 'Titre de l\'annonce'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description de l'annonce",
                'attr' => [
                    'placeholder' => 'Description de l\'annonce'
                ]
            ])
            ->add('price', NumberType::class, [
                'label' => "Prix",
                'attr' => [
                    'placeholder' => 'Prix'
                ]
            ])
            ->add('car', EntityType::class, [
                'class' => Car::class,
                'choice_label' => 'model',
                'label' => "Voiture",
                'attr' => [
                    'placeholder' => 'Choisissez la voiture'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
?>