<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\MainMenu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MainMenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('metaTitle')
            ->add('description')
            ->add('metaDescription')
            ->add('isCategory')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'placeholder' => 'Kategorie wählen',
                'required' => false
            ])
            ->add('route')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MainMenu::class,
        ]);
    }
}
