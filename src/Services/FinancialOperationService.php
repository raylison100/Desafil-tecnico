<?php

namespace Src\Services;

use Src\Strategies\FinancialOperation\TaxStrategyInterface;

class FinancialOperationService
{
    private float $totalQuantity = 0;
    private float $weightedAverage = 0;
    private float $totalCost = 0;
    private float $totalProfit = 0;
    private float $tax = 0;

    public function buy(int $quantity, float $price): void
    {
        $newTotalQuantity = $this->totalQuantity + $quantity;
        $newTotalCost = $this->totalCost + ($quantity * $price);
        $newWeightedAverage = ($this->totalQuantity * $this->weightedAverage + $quantity * $price) / $newTotalQuantity;

        $this->totalQuantity = $newTotalQuantity;
        $this->totalCost = $newTotalCost;
        $this->weightedAverage = $newWeightedAverage;
        $this->tax = 0;
    }

    public function sell(int $quantity, float $price, TaxStrategyInterface $taxStrategy): void
    {
        $totalOperation = $quantity * $price;
        $profit = $quantity * ($price - $this->weightedAverage);

        if ($profit > 0) {
            $this->calculatePositiveProfit($profit, $totalOperation, $taxStrategy);
        } else {
            $this->calculateNegativeProfit($profit);
        }

        $this->totalQuantity -= $quantity;

        if ($this->totalQuantity == 0) {
            $this->totalCost = 0;
            $this->totalProfit = 0;
        }
    }

    private function calculatePositiveProfit(
        float $profit,
        float $totalOperation,
        TaxStrategyInterface $taxStrategy
    ): void {
        if ($this->totalProfit < 0) {
            // Deduct past losses from current profit
            $this->totalProfit = $profit - abs($this->totalProfit);
            $this->tax = $taxStrategy->calculateTax($this->totalProfit);
            $this->totalProfit -= $this->tax;
        } elseif ($totalOperation > 20000) {
            $this->tax = $taxStrategy->calculateTax($profit);
            $this->totalProfit += $profit - $this->tax;
        } else {
            // No taxes for profits below 20000
            $this->totalProfit += $profit;
            $this->tax = 0;
        }
    }

    private function calculateNegativeProfit(float $profit): void
    {
        // Deduct losses from future profits
        $this->totalProfit += $profit;
        $this->tax = 0;
    }

    public function getTax(): float
    {
        return $this->tax;
    }

    public function getTotalProfit(): float
    {
        return $this->totalProfit;
    }

    public function getTotalCost(): float
    {
        return $this->totalCost;
    }
}