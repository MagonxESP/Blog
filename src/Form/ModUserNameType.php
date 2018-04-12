<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 22/03/18
 * Time: 15:53
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModUserNameType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('newUserName', TextType::class, [
            'label' => 'Nombre de usuario nuevo',
            'required' => 'required',
            'attr' => [
                'class' => 'form-username form-control'
            ]
        ])
        ->add('change', SubmitType::class, [
            'label' => 'Cambiar nombre de usuario',
            'attr' => [
                'class' => 'form-submit btn btn-success'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        /*
        $resolver->setDefaults([
            'data_class' => 'App\Entity\User'
        ]);
        */
    }

}