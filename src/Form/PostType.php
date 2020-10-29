<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\ImageGallery;
use App\Entity\Post;
use App\Entity\PostFile;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'row_attr' => ['class' => 'row'],
                'attr' => ['class' => 'form-control-lg'],
                'label_attr' => ['class' => 'col-md-2 col-form-label col-form-label-lg'],
                'help_attr' => ['class' => 'col-12'],
            ])
            ->add('metaTitle', TextType::class, [
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'col-md-2 col-form-label'],
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'placeholder' => 'Tags...',
                'required' => false,
                'by_reference' => true,
                'attr' => ['class' => 'custom-select'],
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'col-md-2 col-form-label'],
                'help' => 'Unbedingt bei News angeben.'
            ])
            ->add('imageFile', VichImageType::class,[
                'attr' => ['class' => 'col-md-9'],
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'col-md-3 col-form-label'],
                'required' => false,
                'allow_delete' => true,
                'download_link' => false,
                'delete_label' => 'Bild löschen?',
                'download_label' => 'Bild laden',
                'download_uri' => true,
                'image_uri' => true,
                'imagine_pattern' => 'admin_preview',
                'asset_helper' => true,
            ])
            ->add('isLocalEntry', CheckboxType::class, [
                'label_attr' => ['class' => 'switch-custom'],
                'required' => false,
                'help' => 'Zeigt den Post auch im lokaen Menü, sofern er einer direkten Kategorie angehört.'
            ])
            ->add('hasContentTable', CheckboxType::class, [
                'label_attr' => ['class' => 'switch-custom'],
                'required' => false,
                'help' => 'Zeigt das Inhaltsverzeichnis im Parent Post an.'
            ])
            ->add('parent', EntityType::class, [
                'class' => Post::class,
                'attr' => ['class' => 'custom-select'],
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'col-md-3 col-form-label'],
                'help_attr' => ['class' => 'col-12'],
                'placeholder' => 'gehört zu Post...',
                'required' => false,
                'by_reference' => true,
                'choice_label' => function($post, $key, $index) {
                    /** @var Category $post */
                    return $post->getCategory() . ' | ' . $post->getTitle();
                },
                'help' => 'Übergeordneter Artikel.'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'attr' => ['class' => 'custom-select'],
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'col-md-3 col-form-label'],
                'help_attr' => ['class' => 'col-12'],
                'placeholder' => 'Kategorie wählen...',
                'expanded' => false,
                'required' => false,
                'help' => 'Nicht notwendig, wenn einem übergeordneten Artikel zugehörig.'
            ])
            ->add('description',TextareaType::class,[
                'required' => false,
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'col-md-2 col-form-label'],
            ])
            ->add('metaDescription',TextareaType::class,[
                'required' => false,
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'col-md-2 col-form-label'],
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'tinymce min-height-800',
                ],
                'required' => false
            ])
            ->add('isLeadStory', CheckboxType::class, [
                'label_attr' => ['class' => 'switch-custom'],
                'required' => false,
                'help' => 'Als Leitartikel in Storys anzeigen.'
            ])
            ->add('hasTemplate', CheckboxType::class, [
                'label_attr' => ['class' => 'switch-custom'],
                'required' => false,
                'help' => 'Artikel verwendet ein eigenes Template.'
            ])
            ->add('template', TextType::class, [
                'help' => 'Pfad zum Template erforderlich, wenn "eigenes Template" verwendet wird.',
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'col-md-3 col-form-label'],
                'help_attr' => ['class' => 'col-12'],
                'required' => false
            ])
            ->add('link', TextType::class, [
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'col-md-3 col-form-label'],
                'help_attr' => ['class' => 'col-12'],
                'required' => false
            ])
            ->add('linkTitle', TextType::class, [
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'col-md-3 col-form-label'],
                'help_attr' => ['class' => 'col-12'],

            ])
            ->add('imageGallery', EntityType::class, [
                'class' => ImageGallery::class,
                'attr' => ['class' => 'custom-select'],
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'col-md-5 col-form-label'],
                'placeholder' => 'Image Gallery wählen...',
                'required' => false,
            ])
            ->add('postFiles', EntityType::class, [
                'class' => PostFile::class,
                'row_attr' => ['class' => 'row'],
                'label_attr' => ['class' => 'col-md-3 col-form-label'],
                'help_attr' => ['class' => 'col-12'],
                'by_reference' => true,
                'required' => false,
                'multiple' => true
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
