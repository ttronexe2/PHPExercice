<?php
require_once "item.php";
require_once "naming.php";

class Warehouse implements Name
{
    private $name;
    private $address;
    private $city;
    private $slots;
    private $maxX;
    private $maxY;

    public function __construct($address, $city, $maxX, $maxY)
    {
        $this->address = $address;
        $this->city = $city;
        $this->maxX = $maxX;
        $this->maxY = $maxY;
        $this->slots = array_fill(0, $maxX, array_fill(0, $maxY, null));
    }

    public function getName()
    {
        return "Warehouse located at " . $this->address . ", " . $this->city;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function add($item)
    {
        for ($x = 0; $x < $this->maxX; $x++) {
            for ($y = 0; $y < $this->maxY; $y++) {
                if (empty($this->slots[$x][$y])) {
                    $this->slots[$x][$y] = $item;
                    return;
                }
            }
        }
    }

    public function remove($x, $y)
    {
        if (isset($this->slots[$x][$y])) {
            $this->slots[$x][$y] = null;
        }
    }

    public function order()
    {
        $items = [];
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item !== null) {
                    $items[] = $item;
                }
            }
        }
        usort($items, function ($a, $b) {
            return get_class($a) <=> get_class($b);
        });
        return $items;
    }

    public function removeBlanks()
    {
        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                if ($item === null) {
                    $this->remove($x, $y);
                }
            }
        }
    }

    public function search($name)
    {
        $foundItems = [];
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item !== null && $item->getName() === $name) {
                    $foundItems[] = $item;
                }
            }
        }
        return [
            'count' => count($foundItems),
            'items' => $foundItems,
        ];
    }

    public function searchByType(...$types)
    {
        $result = [];
        $itemsFound = [];
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item !== null && $item instanceof Food) {
                    foreach ($types as $type) {
                        if (in_array($type, $item->getType())) {
                            $itemsFound[] = $item;
                            break;
                        }
                    }
                }
            }
        }
        $result['count'] = count($itemsFound);
        $result['items'] = $itemsFound;
        return $result;
    }


    public function searchExpired()
    {
        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                if ($item instanceof Expendable && $item->isExpire()) {
                    $this->remove($x, $y);
                }
            }
        }
    }

    public function cleanWarehouse()
    {
        for ($x = 0; $x < $this->maxX; $x++) {
            for ($y = 0; $y < $this->maxY; $y++) {
                $this->remove($x, $y);
            }
        }
    }

    public function sumPriceItems()
    {
        $total = 0;
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item !== null) {
                    $total += $item->calcPriceWithTax();
                }
            }
        }
        return $total;
    }

    public function avgPriceItems()
    {
        $totalPrice = $this->sumPriceItems();
        $itemCount = 0;
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item !== null) {
                    $itemCount++;
                }
            }
        }
        return $itemCount > 0 ? $totalPrice / $itemCount : 0;
    }

    public function printInventory()
    {
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item !== null) {
                    echo $item . "<br>";
                }
            }
        }
    }

    public function totalLitersOfDrinks()
    {
        $totalLiters = 0;
        $alcoholicLiters = 0;
        $nonAlcoholicLiters = 0;

        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item instanceof Drink) {
                    $liters = $item->toLiters();
                    $totalLiters += $liters;
                    if ($item->getIsAlcholic()) {
                        $alcoholicLiters += $liters;
                    } else {
                        $nonAlcoholicLiters += $liters;
                    }
                }
            }
        }

        $alcoholicPercentage = $totalLiters > 0 ? ($alcoholicLiters / $totalLiters) * 100 : 0;
        $nonAlcoholicPercentage = $totalLiters > 0 ? ($nonAlcoholicLiters / $totalLiters) * 100 : 0;

        echo "Total Liters: " . $totalLiters . "L<br>";
        echo "Alcoholic Drinks: " . $alcoholicPercentage . "%<br>";
        echo "Non-Alcoholic Drinks: " . $nonAlcoholicPercentage . "%<br>";
    }

    public function printExpirationsBetweenDates($startDate, $endDate)
    {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);

        $foundItems = [];
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item instanceof Expendable) {
                    if ($item->getExpireDate() >= $start && $item->getExpireDate() <= $end) {
                        $foundItems[] = $item;
                    }
                }
            }
        }

        if (empty($foundItems)) {
            echo "No items found between " . $start->format('Y-m-d') . " and " . $end->format('Y-m-d') . ".<br>";
            return;
        }

        echo "Items expiring between " . $start->format('Y-m-d') . " and " . $end->format('Y-m-d') . ":<br>";
        foreach ($foundItems as $item) {
            echo $item . "<br>";
        }
    }




    public function __toString()
    {
        return "Warehouse: " . $this->address . ", " . $this->city . " (Max X: " . $this->maxX . ", Max Y: " . $this->maxY . ")";
    }
}
