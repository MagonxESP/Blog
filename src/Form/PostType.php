<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 22/03/18
 * Time: 16:14
 */

namespace App\Form;

use App\Type\TagInputType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, [
            'label' => 'Titulo',
            'required' => 'required',
            'attr' => [
                'class' => 'form-title form-control'
            ]
        ])
        ->add('tags', TagInputType::class, [
            'label' => 'Tags',
            'attr' => [
                'id' => 'input-tags',
                //'data-role' => 'tagsinput',
                'class' => 'form-tags form-control'
            ]
        ])
        ->add('content', TextareaType::class, [
            'label' => 'Contenido del post',
            'required' => false,
            'attr' => [
                'id' => 'post-editor',
                'class' => 'form-content'
            ]
        ])
        ->add('publicar', SubmitType::class, [
            'label' => 'Publicar',
            'attr' => [
                'class' => 'btn btn-success'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Post'
        ]);
    }

}