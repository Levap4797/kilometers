<?php

namespace App\Interfaces;

interface GenerationInterface
{
    /**
     *
     *
     * @param array $data
     * @return string file path
     */
    public function generate(array $data): string;
}
