<?php

namespace App\Http\Form;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Brand;
use App\Domain\Mods\Entity\Mod;
use App\Http\Admin\Data\Mods\ModCrudData;
use App\Http\Admin\Type\CategoryModType;
use App\Http\Admin\Type\UserChoiceType;
use App\Http\Type\DateTimeType;
use App\Http\Type\EditorType;
use App\Http\Type\SwitchType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ModEventCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('url', UrlType::class)
            ->add('content', EditorType::class)
            ->add('version', TextType::class)
            ->add('createdAt', DateTimeType::class)
            ->add('author', UserChoiceType::class)
            ->add('console', SwitchType::class)
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'query_builder' =>  function (EntityRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('category', CategoryModType::class)
            // ->add('creator', UserChoiceType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ModCrudData::class,
        ]);
    }
}
