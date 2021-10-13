<?php

namespace App\UI\Product\Form;

use App\Application\Product\Command\CreateProductCommand;
use App\Domain\Product\Currencies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreateProductType extends AbstractType
{
    private Currencies $currencies;

    public function __construct(Currencies $currencies)
    {
        $this->currencies = $currencies;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('price', MoneyType::class, [
                'divisor' => 100,
            ])
            ->add('currencyId', ChoiceType::class,[
                'choices' => $this->currencies->getFormList(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => CreateProductCommand::class
            ])
        ;
    }
}
