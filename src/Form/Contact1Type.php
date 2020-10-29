<?php

namespace App\Form;

use App\Entity\Contact;
use App\Form\Type\PostalAddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Contact1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', ChoiceType::class, [
                'attr' => ['class' => 'custom-select'],
                'help_attr' => ['style' => 'margin-left:.75rem'],
                'label_attr' => ['class' => 'required'],
                'choices' => [
                    'Angebotsanfrage' => 'Angebotsanfrage',
                    'Allgemeine Mitteilung' => 'Allgemeine Mitteilung',
                    'Supportanfrage' => 'Supportanfrage',
                    'Pressekontakt' => 'Pressekontakt',
                ],
                'help' => 'Bitte benenne das zutreffendste Thema.',
                'required' => true,
                'placeholder' => 'Thema wählen...',
                'multiple' => false
            ])
            ->add('content', TextareaType::class, [
                'attr' => ['placeholder' => 'Deine Nachricht an uns', 'style' => 'min-height:140px'],
                'label_attr' => ['class' => 'required'],
                'help_attr' => ['style' => 'margin-left:.75rem'],
                'label' => 'Deine Nachricht an uns',
                'required' => true
            ])
            ->add('firstname', TextType::class, [
                'attr' => ['placeholder' => 'Vorname'],
                'help_attr' => ['style' => 'margin-left:.75rem'],
                'label_attr' => ['class' => 'required'],
                'required' => true,
                'label' => 'Vorname'
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['placeholder' => 'Nachname'],
                'help_attr' => ['style' => 'margin-left:.75rem'],
                'label_attr' => ['class' => 'required'],
                'required' => true,
                'label' => 'Nachname'
            ])
            ->add('address', PostalAddressType::class, [
                'required' => false,
            ])
            ->add('company', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Firma'],
                'help_attr' => ['style' => 'margin-left:.75rem'],
                'label' => 'Firma',
            ])
            ->add('email', TextType::class, [
                'attr' => ['placeholder' => 'E-Mail-Adresse'],
                'help_attr' => ['style' => 'margin-left:.75rem'],
                'label_attr' => ['class' => 'required'],
                'required' => true,
                'label' => 'E-Mail-Adresse',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
