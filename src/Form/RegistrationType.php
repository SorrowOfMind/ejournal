<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{EmailType, RepeatedType, PasswordType};

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr'=>['class'=>'form-control form-input'],
                'label_attr'=>['class'=>'form-label']
            ])
            ->add('password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'required'=>true,
                'first_options'=>[
                    'label'=>'Password', 
                    'attr'=>['class'=>'form-control form-input'],
                    'label_attr'=>['class'=>'form-label']
                ],
                'second_options'=>[
                    'label'=>'Confirm Password', 
                    'attr'=>['class'=>'form-control form-input'],
                    'label_attr'=>['class'=>'form-label']
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
