<?php

namespace App\UI\Cart\Form;

use App\Application\Cart\Command\RemoveProductFromCartCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RemoveProductFromCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cartId', IntegerType::class)
            ->add('productId', IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => RemoveProductFromCartCommand::class
            ])
        ;
    }
}
