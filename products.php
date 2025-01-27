<?php
//error_reporting(0); // Skrývá warning-y

$conn = new mysqli('localhost', 'root', '', 'products');

if($conn){
    echo "Connection successful!"; 
}else{
    die;
    echo "Connection failed...";
}

$vendor = 10;
$products = 100000;


$stopwatch = new Stopwatch;

$stopwatch->start();
for($j = 1; $j <= $vendor; $j++){
    $rVenName = Idk::RandomName();
    $pls[] = "('$j', '$rVenName')";
}
$vendor_sql = "INSERT INTO vendor (id, name) VALUES " . implode(", ", $pls);
$conn->query($vendor_sql);

for($i = 1; $i <= $products; $i++){
    $rName = Idk::RandomName();
    $rPrice = random_int(50, 100);
    $rVenId = random_int(1, $vendor);
    $sql[] = "('$i', '$rName', '$rPrice', '$rVenId')";

    if ($i % 1000 == 0 || $i == $products) {
        $product_sql = "INSERT INTO product (id, name, price, vendor_id) VALUES " . implode(", ", $sql);
        $conn->query($product_sql);
        $sql = []; 
    }
}


echo "<br>";
$stopwatch->stop();

class Idk{

    public static function RandomName(){
        $char_string = "abcdefghijklmnopqrstuvwxyz";
        $lenght = random_int(1, 10);
        $string = '';
        while(strlen($string) < $lenght){
            $string .= $char_string[random_int(0, strlen($char_string) -1 )];
        }
        return $string;
    }
}

class Stopwatch
{
    private static $time;

    public static function start()
    {
        self::$time = microtime(true);
    }

    public static function stop()
    {
        printf(
            "[Stopwatch: %.6f ms]" . PHP_EOL,
            (microtime(true) - self::$time) * 1000
        );
        self::start();
    }
}