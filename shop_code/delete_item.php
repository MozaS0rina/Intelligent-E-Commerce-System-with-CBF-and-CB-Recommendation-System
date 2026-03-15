<?php
require 'vendor/autoload.php';

use Recombee\RecommApi\Client as RecombeeClient;
use Recombee\RecommApi\Requests\AddItem;
use Recombee\RecommApi\Requests\GetItemValues;
use Recombee\RecommApi\Requests\DeleteItem;


$client = new RecombeeClient('RECOMBEE_DB', 'RECOMBEE_KEY',
                             ['region' =>'RECOMBEE_REGION'], ['verify' => false]);
try {
    
    // Check if the item exists by retrieving its values
    $getItemResponse = $client->send(new GetItemValues('item-1'));
    echo 'Item details: <pre>' . print_r($getItemResponse, true) . '</pre>';

    // Delete the item
    $deleteItemResponse = $client->send(new DeleteItem('item-1'));
    echo 'Item deleted successfully!';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>