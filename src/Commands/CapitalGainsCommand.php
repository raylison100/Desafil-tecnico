<?php

namespace Src\Commands;

use Src\Models\Operation;
use Src\Services\FinancialOperationService;
use Src\Strategies\FinancialOperation\ConservativeTaxStrategy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CapitalGainsCommand extends Command
{
    protected function configure()
    {
        $this->setName('capital-gains');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (file_exists("src/Files/inputs.txt")) {
            $inputFile = file_get_contents("src/Files/inputs.txt");

            $operation = new Operation();
            $operation->setInputs(json_decode($inputFile, true));

            $financialOperation = new FinancialOperationService();

            foreach ($operation->getInputs() as $input) {
                $quantity = $input['quantity'];
                $unitCost = $input['unit-cost'];
                $operationType = $input['operation'];

                if ($operationType == 'buy') {
                    $financialOperation
                        ->buy($quantity, $unitCost);
                }

                if ($operationType == 'sell') {
                    $financialOperation
                        ->sell($quantity, $unitCost, new ConservativeTaxStrategy());
                }

                $operation->setOutputs(['tax' => number_format($financialOperation->getTax(), 2)]);
            }

            dd($operation->getOutputs());
        }
    }
}