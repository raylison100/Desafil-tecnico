<?php

namespace Src\Strategies\FinancialOperation;

class AggressiveTaxStrategy implements TaxStrategyInterface
{
    public function calculateTax($profit): float
    {
        return max(0, $profit) * 0.4;
    }
}