<?php


namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PostalAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('phone', TelType::class, [
            'attr' => ['placeholder' => 'Telefon'],
            'label' => 'Telefon'
        ])
        ->add('addressLine1', TextType::class, [
            'help' => 'Anschrift, Postfach',
            'attr' => ['placeholder' => 'Anschrift'],
            'label' => 'Anschrift'
        ])
        ->add('addressLine2', TextType::class, [
            'help' => 'Etage, Abteilung, Gebäude',
            'attr' => ['placeholder' => 'Adresszusatz'],
            'label' => 'Adresszusatz'
        ])
        ->add('city', TextType::class, [
            'attr' => ['placeholder' => 'Ort'],
            'label' => 'Ort'
        ])
        ->add('state', TextType::class, [
            'attr' => [
                'placeholder' => 'Bundesland',
                'list' => 'state_list',
                'class' => '',
                'data-min-length' => '3'
            ],
            'label' => 'Bundesland'
        ])
        ->add('zipcode', TextType::class, [
            'attr' => ['placeholder' => 'Postleitzahl'],
            'label' => 'Postleitzahl'
        ]);
    }


}