<?php
require_once "item.php";

class Expendable extends Item
{
    private $expireDate;
    protected $tax = 10;

    public function __construct($name, $price, $weight, $isNew, $expireDate, $tax = 10)
    {
        parent::__construct($name, $price, $weight, $isNew);
        $this->expireDate = new DateTime($expireDate);
        $this->tax = $tax;
    }

    public function __toString()
    {
        return " <b>Name:</b> " . parent::__toString() .
               " <b>Price:</b> " . $this->getPrice() .
               " <b>Weight:</b> " . $this->getWeight() .
               " <b>Is New:</b> " . $this->getIsNew() .
               " <b>(Expire Date:</b> " . $this->expireDate->format('Y-m-d') . "<b>)</b>" .
               " <b>Price with Tax:</b> " . $this->calcPriceWithTax();
    }

    public function calcPriceWithTax()
    {
        return $this->getPrice() + ($this->getPrice() * $this->tax / 100);
    }

    public function isExpire()
    {
        $today = new DateTime();
        return $today > $this->expireDate;
    }

    public function getExpireDate()
    {
        return $this->expireDate;
    }
}
