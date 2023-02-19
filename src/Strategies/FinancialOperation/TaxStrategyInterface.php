<?php

namespace Src\Strategies\FinancialOperation;

interface TaxStrategyInterface
{
    public function calculateTax(float $profit): float;
}