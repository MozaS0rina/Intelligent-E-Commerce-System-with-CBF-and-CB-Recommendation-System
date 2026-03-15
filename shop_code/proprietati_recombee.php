<?php
require 'vendor/autoload.php'; 
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddItemProperty;

$client = new RecombeeClient('RECOMBEE_DB', 'RECOMBEE_KEY',
                             ['region' =>'RECOMBEE_REGION'], ['verify' => false]);

// Creează proprietăți pentru item-uri
try {
    // Adăugare proprietăți
    $client->send(new AddItemProperty('name', 'string')); // Numele produsului (text)
    $client->send(new AddItemProperty('material', 'string')); // Materialul produsului (text)
    $client->send(new AddItemProperty('price', 'double')); // Prețul produsului (numeric)
    $client->send(new AddItemProperty('quantity', 'int')); // Cantitatea produsului (numeric întreg)
    $client->send(new AddItemProperty('description', 'string')); // Descrierea produsului (text)
    $client->send(new AddItemProperty('specifications', 'string')); // Specificații (text)
    $client->send(new AddItemProperty('image', 'string')); // URL imagine (text)
    $client->send(new AddItemProperty('category', 'string')); // Categorie produs (text)

    echo "Proprietățile item-urilor au fost create cu succes!";
} catch (Exception $e) {
    echo "Eroare la crearea proprietăților: " . $e->getMessage();
}
?>