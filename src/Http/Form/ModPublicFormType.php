<?php

namespace App\Http\Form;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Brand;
use App\Domain\Mods\Entity\Category;
use App\Domain\Mods\Entity\Mod;
use App\Domain\Mods\Repository\CategoryRepository;
use App\Domain\Profile\Dto\ModDto;
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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ModPublicFormType extends AbstractType
{
    public function __construct(private CategoryRepository $repository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $tags = $this->repository->findAllOrdered();
        $builder
            ->add('title', TextType::class)
            ->add('url', TextType::class)
            ->add('content', EditorType::class)
            ->add('version', TextType::class)
            ->add('console', SwitchType::class)
           ->add('brand', EntityType::class, [
              'class' => Brand::class,
                'query_builder' =>  function (EntityRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.name', 'ASC');
                },
                'choice_label' => 'name',
               'placeholder' => 'Choisir une Marque'
            ])
            ->add('category', EntityType::class, [
                'required' => false,
                'multiple' => true,
                'attr' => [
        'data-limit' => 2,
                ],
                'class' => Category::class,
                'choices' => $tags,
                'query_builder' => null,
                'choice_label' => function (Category $tag) {
                    $prefix = $tag->getParent() ? '??????' : '';

                    return $prefix.$tag->getName();
                },
            ]);
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mod::class,
        ]);
    }
}
