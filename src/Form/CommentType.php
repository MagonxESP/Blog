<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 2/05/18
 * Time: 17:21
 */

namespace App\Form;

//use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('content', TextareaType::class, [
            'label' => 'Escribir un comentario',
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        ->add('publish', SubmitType::class, [
            'label' => 'Publicar',
            'attr' => [
                'class' => 'btn btn-success'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
           'data_class' => 'App\Entity\Comment'
        ]);
    }
}