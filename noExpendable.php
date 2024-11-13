<?php
require_once "item.php";
require_once "naming.php";
class NoExpendable extends Item implements Name
{
    private $warrantyDueDate;
    private $purchaseDate;
    private $tax = 21;

    public function __construct($name, $price, $weight, $isNew, $warrantyDueDate, $purchaseDate, $tax)
    {
        parent::__construct($name, $price, $weight, $isNew);
        $this->warrantyDueDate = null;
        $this->purchaseDate = $purchaseDate;
        $this->tax = $tax;
    }

    public function getName()
    {
        return parent::getName();
    }

    public function setName($name)
    {
        $this->name = parent::setName($name);
    }

    public function getwarantyDueDate()
    {
        return $this->warrantyDueDate;
    }

    public function setWarrantyDueDate($warrantyDueDate)
    {
        $this->warrantyDueDate = $warrantyDueDate;
    }

    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;
    }

    public function getTax()
    {
        return $this->tax;
    }

    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    public function fullfillwarranty()
    {
        $today = new DateTime();

        $warrantyDueDate = clone $today;
        $warrantyDueDate->modify('+2 years');

        $warrantyDueDate = date("Y-m-d");
    }

    public function calcPriceWithTax()
    {
        return $this->price + ($this->price * $this->tax / 100);
    }
}
