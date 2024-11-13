<?php
require_once "expendable.php";
class Drink extends Expendable
{
    private $isAlcholic;
    private $volume;

    public function __toString()
    {
        return parent::__toString() . " (Volume: " . $this->volume . ")";
    }
    public function __construct($name, $price, $weight, $isNew, $expireDate, $tax, $isAlcholic, $volume)
    {
        parent::__construct($name, $price, $weight, $isNew, $expireDate, $tax);
        $this->isAlcholic = $isAlcholic;
        $this->volume = $volume;
        $this->tax = ($isAlcholic) ? 21 : $tax;
    }
    public function getIsAlcholic()
    {
        return $this->isAlcholic;
    }

    public function setIsAlcholic($isAlcholic)
    {
        $this->isAlcholic = $isAlcholic;
    }

    public function getVolume()
    {
        return $this->volume;
    }

    public function setVolume($volume)
    {
        $this->volume = $volume;
    }

    public function toLiters()
    {
        return $this->volume / 1000;
    }

    public function toGalons()
    {
        return $this->volume / 3785.41;
    }
}
