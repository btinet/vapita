<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\FlashMessage;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('metaTitle')
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
            ->add('redirectToPost')
            ->add('isDarkLocalMenu')
            ->add('isShown')
            ->add('isLead', BooleanType::class)
            ->add('description')
            ->add('meteDescription')
            ->add('parent', EntityType::class, [
                'class' => Category::class,
                'placeholder' => 'Kategorie wählen',
                'required' => false,
                'by_reference' => true
            ])
            ->add('flashMessages', EntityType::class, [
                'class' => FlashMessage::class,
                'placeholder' => 'Flash Message wählen',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
