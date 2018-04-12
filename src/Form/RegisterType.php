<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 12/03/18
 * Time: 19:56
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('Username', TextType::class, [
            'label' => 'Nombre de usuario',
            'required' => 'required',
            'attr' => [
                'class' => 'form-username form-control'
            ]
        ])
        ->add('Password', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => 'required',
            'first_options' => [
                'label' => 'Contraseña',
                'attr' => [
                    'class' => 'form-password form-control'
                ]
            ],
            'second_options' => [
                'label' => 'Repetir contraseña',
                'attr' => [
                    'class' => 'form-password form-control'
                ]
            ]
        ])
        ->add('Registrarme', SubmitType::class, [
            'label' => 'Registrame',
            'attr' => [
                'class' => 'form-submit btn btn-success'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\User'
        ]);
    }

}