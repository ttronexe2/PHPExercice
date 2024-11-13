<?php
// Joshua Abril i Adrià Baltrons
require_once "item.php";
require_once "expendable.php";
require_once "food.php";
require_once "drink.php";
require_once "noExpendable.php";
require_once "warehouse.php";


$drink1 = new Drink("Coca-Cola", 1.50, 350, true, "2025-01-01", 10, false, 500);
$drink2 = new Drink("Agua Mineral", 0.80, 500, true, "2024-12-31", 10, false, 1000);


echo "<h1>===== Drinks =====</h1>";
echo "Drink 1: " . $drink1 . "<br>";
echo "Is Alcoholic: " . ($drink1->getIsAlcholic() ? "Yes" : "No") . "<br>";
echo "Volume in liters: " . $drink1->toLiters() . "L<br>";
echo "Volume in gallons: " . $drink1->toGalons() . "G<br><br>";

echo "Drink 2: " . $drink2 . "<br>";
echo "Is Alcoholic: " . ($drink2->getIsAlcholic() ? "Yes" : "No") . "<br>";
echo "Volume in liters: " . $drink2->toLiters() . "L<br>";
echo "Volume in gallons: " . $drink2->toGalons() . "G<br><br>";


$food1 = new Food("Pizza", 12.00, 800, true, "2024-10-30", 10, "Comida Rápida");
$food2 = new Food("Ensalada", 5.50, 300, true, "2024-10-29", 10, "Vegetariana");


echo "<h1>===== Foods =====</h1>";
echo "Food 1: " . $food1 . "<br>";
echo "Food Type: " . implode(", ", $food1->getType()) . "<br>";
echo "Food 2: " . $food2 . "<br>";
echo "Food Type: " . implode(", ", $food2->getType()) . "<br><br>";


$item1 = new NoExpendable("Laptop", 1200, 2000, true, null, "2022-10-01", 21);
$item2 = new NoExpendable("Teléfono", 800, 150, true, null, "2023-05-15", 21);


$item3 = new Expendable("Caducado", 10, 100, true, "2023-01-01", 10);


echo "<h1>===== NoExpendables =====</h1>";
echo "Item 1: " . $item1 . "<br>";
echo "Item 2: " . $item2 . "<br>";
echo "Item 1 Tax: " . $item1->getTax() . "%<br>";
echo "Item 1 Price with Tax: " . $item1->calcPriceWithTax() . "<br><br>";


$warehouse = new Warehouse("Calle Falsa 123", "Madrid", 5, 5);


$warehouse->add($drink1);
$warehouse->add($drink2);
$warehouse->add($food1);
$warehouse->add($food2);
$warehouse->add($item1);
$warehouse->add($item2);
$warehouse->add($item3);


echo "<h1>===== Warehouse Inventory =====</h1>";
$warehouse->printInventory();
echo "<br>";


echo "<h1>===== Ordered Items by Class =====</h1>";
$orderedItems = $warehouse->order();
foreach ($orderedItems as $item) {
    echo $item . "<br>";
}
echo "<br>";

echo "<h1>===== Sum of Prices of Items =====</h1>";
echo "Total Price with Tax: " . $warehouse->sumPriceItems() . "<br><br>";

echo "<h1>===== Average Price of Items =====</h1>";
echo "Average Price with Tax: " . $warehouse->avgPriceItems() . "<br><br>";

echo "<h1>===== Total Liters of Drinks =====</h1>";
$warehouse->totalLitersOfDrinks();
echo "<br>";

$searchName = "Coca-Cola";
echo "<h1>===== Search for Item: $searchName =====</h1>";
$searchResult = $warehouse->search($searchName);
echo "Found {$searchResult['count']} items:<br>";
foreach ($searchResult['items'] as $item) {
    echo $item . "<br>";
}
echo "<br>";

echo "<h1>===== Search Food by Type =====</h1>";
$searchResult = $warehouse->searchByType("Comida Rápida", "Vegetariana");
echo "Number of Foods found: " . $searchResult['count'] . "<br>";
foreach ($searchResult['items'] as $food) {
    echo $food . "<br>";
}


$warehouse->searchExpired();
echo "<h1>===== Warehouse Inventory After Removing Expired Items =====</h1>";
$warehouse->printInventory();
echo "<br>";

echo "<h1>===== Print Expirations Between Dates =====</h1>";
$warehouse->printExpirationsBetweenDates("2024-10-01", "2024-12-31");

echo "<h1>===== Clean Warehouse =====</h1>";
$warehouse->cleanWarehouse();
echo "Warehouse cleaned.<br><br>";

echo "<h1>===== Warehouse Inventory After Cleaning =====</h1>";
$warehouse->printInventory();
echo "<br>";
