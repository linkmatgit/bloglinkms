<?php

namespace App\Http\Admin\Type;

use App\Domain\Blog\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends EntityType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
        'class' => Category::class,
        'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('c')
            ->where('c.online = true')
            ->orderBy('c.name', 'ASC');
        },
        'choice_label' => 'name',
        ]);
    }
}
