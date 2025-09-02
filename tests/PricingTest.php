<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Pricing.php';

final class PricingTest extends TestCase
{
    public function testCalculatePriceNoDiscountsOnWeekend(): void
    {
        $pricing = new Pricing();
        // Samedi
        $price = $pricing->calculatePrice(2, '2023-12-23 14:00');
        $this->assertSame(40.00, $price);
    }

    public function testCalculatePriceWeekdayDiscount(): void
    {
        $pricing = new Pricing();
        // Lundi
        $price = $pricing->calculatePrice(2, '2023-12-18 14:00');
        $this->assertSame(36.00, $price);
    }

    public function testCalculatePriceGroupDiscountWeekend(): void
    {
        $pricing = new Pricing();
        // Samedi, groupe de 4
        $price = $pricing->calculatePrice(4, '2023-12-23 14:00');
        $this->assertSame(68.00, $price);
    }

    public function testCalculatePriceBothDiscountsWeekdayGroup(): void
    {
        $pricing = new Pricing();
        // Lundi, groupe de 4 -> 80 * 0.9 = 72 -> 72 * 0.85 = 61.2
        $price = $pricing->calculatePrice(4, '2023-12-18 14:00');
        $this->assertSame(61.20, $price);
    }

    public function testApplyDiscountOnly(): void
    {
        $pricing = new Pricing();
        $this->assertSame(90.0, $pricing->applyDiscount(100.0, '2023-12-18 10:00'));
        $this->assertSame(100.0, $pricing->applyDiscount(100.0, '2023-12-23 10:00'));
    }
}

