<?php

namespace Src\Models;

class Operation
{
    private array $inputs;
    private array $outputs;

    /**
     * @return array
     */
    public function getInputs(): array
    {
        return $this->inputs;
    }

    /**
     * @param array $inputs
     */
    public function setInputs(array $inputs): void
    {
        $this->inputs = $inputs;
    }

    /**
     * @return array
     */
    public function getOutputs(): array
    {
        return $this->outputs;
    }

    /**
     * @param array $outputs
     */
    public function setOutputs(array $outputs): void
    {
        $this->outputs[] = $outputs;
    }
}