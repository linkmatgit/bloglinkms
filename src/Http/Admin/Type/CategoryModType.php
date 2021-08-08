<?php
declare(strict_types=1);

namespace App\Http\Admin\Type;

use App\Domain\Mods\Entity\ModCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryModType extends EntityType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'class' => ModCategory::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->where('c.online = true')
                    ->orderBy('c.name', 'ASC');
            },
            'choice_label' => 'name',
            'placeholder' => 'Choisir une category'
        ]);
    }
}
