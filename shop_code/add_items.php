<?php
require 'vendor/autoload.php';

use Recombee\RecommApi\Client as RecombeeClient;
use Recombee\RecommApi\Requests\AddItem;
use Recombee\RecommApi\Requests\GetItemValues;

$client = new RecombeeClient('RECOMBEE_DB', 'RECOMBEE_KEY',
                             ['region' =>'RECOMBEE_REGION'], ['verify' => false]);

try {
    // Add the item
    $addItemResponse = $client->send(new AddItem('item-1', ['title' => 'Product Title']));
    echo 'Item added successfully!<br>';

    // Check if the item exists by retrieving its values
    $getItemResponse = $client->send(new GetItemValues('item-1'));
    echo 'Item details: <pre>' . print_r($getItemResponse, true) . '</pre>';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
