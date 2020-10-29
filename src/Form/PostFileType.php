<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\PostFile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('metaTitle')
            ->add('description')
            ->add('file', VichFileType::class,[
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Datei löschen',
                'download_label' => 'Datei laden',
                'download_uri' => true,
                'asset_helper' => true,
            ])
            ->add('post', EntityType::class, [
                'class' => Post::class,
                'placeholder' => 'Artikel wählen...',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostFile::class,
        ]);
    }
}
