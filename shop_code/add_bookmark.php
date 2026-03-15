<?php
include 'conectare.php';
require 'vendor/autoload.php';
	use Recombee\RecommApi\Client as RecombeeClient;
	use Recombee\RecommApi\Requests as Reqs;
	use Recombee\RecommApi\Requests\AddBookmark;
	use Recombee\RecommApi\Requests\AddUser;
	

$client = new RecombeeClient('RECOMBEE_DB', 'RECOMBEE_KEY',
                             ['region' =>'RECOMBEE_REGION'], ['verify' => false]);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prod_id']) && isset($_POST['u_id'])) {
    $userId = strval($_POST['u_id']);  // ID-ul utilizatorului
    $itemId = strval($_POST['prod_id']); // ID-ul produsului

    try {
        // Înregistrează interacțiunea "bookmark" în Recombee
        $client->send(new Reqs\AddBookmark($userId, $itemId, [
            'cascadeCreate' => true // Creează automat utilizatorul/articolul dacă nu există
        ]));
        echo "Bookmark added successfully!";
    } catch (Exception $e) {
        // Tratează erorile
        echo "Error adding bookmark to Recombee: " . $e->getMessage();
    }
}
?>
