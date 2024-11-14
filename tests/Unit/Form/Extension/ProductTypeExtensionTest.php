<?php

declare(strict_types=1);

namespace App\Tests\Unit\Form\Extension;

use App\Form\Extension\ProductTypeExtension;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductTypeExtensionTest extends TestCase
{
    public function test_it_builds_form(): void
    {
        $extension = new ProductTypeExtension();

        $formBuilder = self::createMock(FormBuilderInterface::class);
        $formBuilder
            ->expects(self::once())
            ->method('add')
            ->with('manufacturer', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', [
                'class' => 'App\Entity\Manufacturer\Manufacturer',
                'choice_label' => 'name',
                'label' => 'app.form.product.manufacturer',
                'placeholder' => 'app.form.product.select_manufacturer',
            ])
        ;

        $extension->buildForm($formBuilder, []);
    }

    public function test_it_extends_types(): void
    {
        self::assertSame([ProductType::class], ProductTypeExtension::getExtendedTypes());
    }
}
