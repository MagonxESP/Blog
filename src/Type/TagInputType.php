<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 23/03/18
 * Time: 19:21
 */

namespace App\Type;

use App\Form\DataTransformer\TagArrayToStringTransformer;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;


class TagInputType extends AbstractType {

    private $tags;

    public function __construct(TagRepository $tags) {
        $this->tags = $tags;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->addModelTransformer(new CollectionToArrayTransformer(), true)
            ->addModelTransformer(new TagArrayToStringTransformer($this->tags), true);
    }

    public function buildView(FormView $view, FormInterface $form, array $options) {
        $view->vars['tags'] = $this->tags->findAll();
    }

    public function getParent() {
        return TextType::class;
    }

}