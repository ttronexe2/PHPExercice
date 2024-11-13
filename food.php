<?php
require_once "expendable.php";
require_once "naming.php";

    class Food extends Expendable implements Name
    {
        protected $type = [];

    public function __toString()
    {
            return parent::__toString() . " (Type: " . implode(", ", $this->type) . ")";
    }

    public function __construct($name, $price, $weight, $isNew, $expireDate, $tax, $type)
    {
            parent::__construct($name, $price, $weight, $isNew, $expireDate, $tax);
            $this->type = is_array($type) ? $type : [$type];
    }

    public function getType()
    {
            return $this->type;
    }

    public function setType($type)
    {
            $this->type = $type;
    }
}
