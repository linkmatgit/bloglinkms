<?php
declare(strict_types=1);

namespace App\Http\Admin\Type;

use App\Domain\Manager\Reason;
use App\Domain\Mods\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReasonType extends EntityType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'class' => Reason::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('r');
            },
            'choice_label' => 'name',
            'placeholder' => 'Choisir une raison'
        ]);
    }
}
