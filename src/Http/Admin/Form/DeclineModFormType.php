<?php declare(strict_types=1);


namespace App\Http\Admin\Form;


use App\Domain\Mods\Entity\Mod;
use App\Http\Admin\Type\ReasonType;
use App\Http\Admin\Type\UserChoiceType;
use App\Http\Type\DateTimeType;
use App\Http\Type\EditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeclineModFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
            $builder->add('reason', ReasonType::class)
                ->add('urlofmod', TextType::class, [
                    'required' =>  false
                ])
                ->add('approuve', ChoiceType::class, [
                    'required' => true,
                    'choices' => array_flip(Mod::$confirm),
                ])
                ->add('statut', ChoiceType::class, [
                    'required' => true,
                    'choices' => array_flip(Mod::$status),
                ])
                ->add('approuveby', UserChoiceType::class)
                ->add('approuveat', DateTimeType::class)
                ->add("detail", EditorType::class)
            ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mod::class,
        ]);
    }
}