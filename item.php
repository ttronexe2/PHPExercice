<?php
require_once "naming.php";
abstract class Item implements Name
{
        protected $name;
        protected $price;
        protected $weight;
        protected $isNew;

    public function getName()
    {
            return $this->name;
    }
    public function setName($name)
    {
            $this->name = $name;
    }
    public function __toString()
    {
            return $this->name;
    }
    public function setNew($isNew)
    {
            $this->isNew = $isNew;
    }
    public function getPrice()
    {
            return $this->price;
    }
    public function setPrice($price)
    {
            $this->price = $price;
    }
    public function getWeight()
    {
            return $this->weight;
    }
    public function setWeight($weight)
    {
            $this->weight = $weight;
    }
    public function getIsNew()
    {
            return $this->isNew;
    }
    public function setIsNew($isNew)
    {
            $this->isNew = $isNew;
    }
    protected function __construct($name, $price, $weight, $isNew)
    {
            $this->name = $name;
            $this->price = $price;
            $this->weight = $weight;
            $this->isNew = $isNew;
    }

    abstract public function calcPriceWithTax();
}
