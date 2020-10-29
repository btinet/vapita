<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\ImageGallery;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('metaTitle')
            ->add('description')
            ->add('imageFile', VichImageType::class,[
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Bild löschen',
                'download_label' => 'Bild laden',
                'download_uri' => true,
                'image_uri' => true,
                'imagine_pattern' => 'admin_preview',
                'asset_helper' => true,
            ])
            ->add('gallery', EntityType::class, [
                'class' => ImageGallery::class,
                'placeholder' => 'Gallerie wählen...',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
