<?php

namespace App\Http\Admin\Type;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Mod;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ModChoiceType extends AbstractType implements DataTransformerInterface
{


    public function __construct(
        private EntityManagerInterface $em,
        private UrlGeneratorInterface $url)
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addViewTransformer($this);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $choices = [];
        $mods = $form->getData();
        if ($mods instanceof Mod) {
            $choices = [new ChoiceView($mods, (string)$mods->getId(), $mods->getTitle())];
        }
        $view->vars['choice_translation_domain'] = false;
        $view->vars['expanded'] = false;
        $view->vars['placeholder'] = null;
        $view->vars['placeholder_in_choices'] = false;
        $view->vars['multiple'] = false;
        $view->vars['preferred_choices'] = [];
        $view->vars['value'] = $mods ? (string)$mods->getId() : 0;
        $view->vars['choices'] = $choices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        'compound' => false,
        'attr' => [
        'is' => 'select-choices',
        'data-remote' => $this->url->generate('api_mod_autocomplete'),
        'data-value' => 'id',
        'data-label' => 'name',
        ],
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'choice';
    }

  /**
   * @param ?Mod $mods
   */
    public function transform($mods): string
    {
        return null === $mods ? '' : (string)$mods->getId();
    }

  /**
   * @param int $modId
   */
    public function reverseTransform($modId): object
    {
        return (object)$this->em->getRepository(Mod::class)->find($modId);
    }
}
