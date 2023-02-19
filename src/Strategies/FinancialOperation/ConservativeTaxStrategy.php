<?php

namespace Src\Strategies\FinancialOperation;

class ConservativeTaxStrategy implements TaxStrategyInterface
{
    public function calculateTax($profit): float
    {
        return max(0, $profit) * 0.2;
    }
}