<?php


interface cleaner{
    public function cleanData() : bool;
    public function getValidData();
}

abstract class filterBuilder implements cleaner{
    protected array $cleandedData;

    public function cleanData(): bool
    {
        return true;
    }
    abstract public function getValidData();
}


