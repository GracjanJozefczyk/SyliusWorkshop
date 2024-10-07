<?php

declare(strict_types=1);

namespace App\Form\Extension;

use App\Entity\Manufacturer\Manufacturer;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('manufacturer', EntityType::class, [
                'class' => Manufacturer::class,
                'choice_label' => 'name',
                'label' => 'app.form.product.manufacturer',
                'placeholder' => 'app.form.product.select_manufacturer',
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [
            ProductType::class
        ];
    }
}
