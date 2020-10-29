<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\ImageGallery;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageGalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('metaTitle')
            ->add('description')
            ->add('parent')
            ->add('images', EntityType::class, [
                'class' => Image::class,
                'by_reference' => false,
                'required' => false,
                'multiple' => true
            ])
            ->add('posts', EntityType::class, [
                'class' => Post::class,
                'by_reference' => false,
                'required' => false,
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImageGallery::class,
        ]);
    }
}
