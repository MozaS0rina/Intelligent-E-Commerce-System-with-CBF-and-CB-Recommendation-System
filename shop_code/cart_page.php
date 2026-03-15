<?php
    include 'header.php';
    include 'conectare.php';
    require 'vendor/autoload.php';
    use Recombee\RecommApi\Client as RecombeeClient;
    use Recombee\RecommApi\Requests\AddDetailView;
    use Recombee\RecommApi\Requests\AddUser;
    use Recombee\RecommApi\Requests\RecommendItemsToUser;
    use Recombee\RecommApi\Requests as Reqs;
    
$is_logged_in = isset($_SESSION['id']); 

$dbName='RECOMBEE_DB';
$key='RECOMBEE_KEY';

    $client = new RecombeeClient($dbName, $key,
                             ['region' =>'RECOMBEE_REGION'], ['verify' => false]);

    if (isset($_GET['info']) && $_GET['info'] === 'delete') {
        $sql = "DELETE FROM cumparaturi WHERE c_id = $_GET[id]";
        mysqli_query($conectare, $sql);
        echo '<script>window.location="cart_page.php"</script>';
    }

    if (isset($_POST['shop'])) {
        $sql = "SELECT * FROM cumparaturi";
        $result = mysqli_query($conectare, $sql);

        $userId = strval($_SESSION['id']);

        // Asigură-te că utilizatorul există în Recombee
        try {
            $client->send(new AddUser($userId));
        } catch (Exception $e) {
            // Tratează excepțiile, dacă este necesar
        }

        while ($reg = mysqli_fetch_assoc($result)) {
            $prodId = strval($reg['c_prod_id']);

            // Adaugă un DetailView pentru fiecare produs achiziționat
            try {
                $client->send(new Reqs\AddPurchase($userId, $prodId, [
                    'cascadeCreate' => true
                ]));
                 $client->send(new Reqs\AddDetailView($userId, $prodId, [
            'cascadeCreate' => true
        ]));
            } catch (Exception $e) {
                // Tratează excepțiile, dacă este necesar
            }

            // Adaugă în istoricul de cumpărături
            mysqli_query($conectare, "INSERT INTO istoric (i_user_id, i_prod_id) VALUES($_SESSION[id], $reg[c_prod_id])");

            // Actualizează cantitatea produsului
            $sqlu = "SELECT * FROM produse WHERE prod_id = $reg[c_prod_id]";
            $resultu = mysqli_query($conectare, $sqlu);
            $row = mysqli_fetch_array($resultu);
            mysqli_query($conectare, "UPDATE produse SET prod_qty = ($row[prod_qty] - $reg[c_qty]) WHERE prod_id = $reg[c_prod_id]");
        }

        // Golește coșul după achiziție
        $sql = "DELETE FROM cumparaturi";
        mysqli_query($conectare, $sql);

        $message = "Your order has been completed successfully!";
        echo "<script>alert('$message');</script>";
        echo '<script>window.location="index.php"</script>';
    }
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<div class="table-responsive">
    <br>
    <table class="table table-bordered">
        <tr>
            <th width="40%">Product Name</th>
            <th width="10%">Quantity</th>
            <th width="20%">Price</th>
            <th width="15%">Total</th>
            <th width="5%">Action</th>
        </tr>
        <?php
            $count_q = 0;
            $sql = "SELECT * FROM cumparaturi INNER JOIN produse ON cumparaturi.c_prod_id=produse.prod_id";
            $result = mysqli_query($conectare, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['prod_name']."</td>";
                echo "<td>".$row['c_qty']."</td>";
                echo "<td>$".$row['prod_price']."</td>";
                echo "<td>$".($row['prod_price'] * $row['c_qty'])."</td>";
                ?>
                <td><a href="cart_page.php?info=delete&id=<?php echo $row['c_id']?>"><input type="submit" name="delete" value="Remove"></a></td>
                <?php
                echo "</tr>";
            }
        ?>
    </table>

    <div class="button" align="center" style="margin-top:5px;" class="btn btn-success">
        <?php if(isset($_SESSION['id'])) { ?>
            <form method="POST">
                <input type="submit" name="shop" value="Shop">
            </form>
        <?php } else {
            echo "Please sign in before placing the order.";
        } ?>
    </div>
</div>

	
<!-- Recommended Products Widget -->
<div class="recommended-widget" style="margin-top:30px;">
    <h1 style="font-size:36px; text-align:left; margin-left:20px; color:#800080;">Options for your cart</h1>
    <div class="main" data-page-type="overview" style="text-align:left;">
        <?php
        if ($is_logged_in) {
            // If user is logged in, fetch recommendations from Recombee
            $client = new RecombeeClient($dbName, $key,
                             ['region' =>'eu-west'], ['verify' => false]);

            $count = 3; // Number of recommendations
            $userId = strval($_SESSION['id']); // Convert user ID to string
            try {
                $result = $client->send(new RecommendItemsToUser($userId, $count, ['scenario' => 'product_detail', 'cascadeCreate' => true]));
                $recommendedIds = $result['recomms']; // Recommended items from Recombee
            } catch (Exception $e) {
                die('Error fetching recommendations from Recombee: ' . $e->getMessage());
            }

            if (count($recommendedIds) < 3) {
                // Fetch random products if recommendations are less than 3
                $results_to_display = 3; // Number of random products
                $sql = "SELECT * FROM produse ORDER BY RAND() LIMIT $results_to_display";
                $result = mysqli_query($conectare, $sql);

                if (!$result) {
                    die("SQL Error: " . mysqli_error($conectare));
                }
            } else {
                // Convert string IDs to integers and build an IN clause for SQL query
                $recommendedIdsArray = [];
                foreach ($recommendedIds as $recommendation) {
                    $recommendedIdsArray[] = intval($recommendation['id']);
                }
                $recommendedIdsList = implode(',', $recommendedIdsArray); // Create comma-separated string

                // Fetch products from the database based on Recombee recommendations
                $sql = "SELECT * FROM produse WHERE prod_id IN ($recommendedIdsList)";
                $result = mysqli_query($conectare, $sql);

                if (!$result) {
                    die("SQL Error: " . mysqli_error($conectare));
                }
            }
        } else {
            // If user is not logged in, fetch random products
            $results_to_display = 3; // Number of random products
            $sql = "SELECT * FROM produse ORDER BY RAND() LIMIT $results_to_display";
            $result = mysqli_query($conectare, $sql);

            if (!$result) {
                die("SQL Error: " . mysqli_error($conectare));
            }
        }
    if (isset($_GET['pid'])) {
    $userId = strval($_SESSION['id']);
    $itemId = strval($_GET['pid']);

    // Asigură-te că utilizatorul există în Recombee
    try {
        $client->send(new AddUser($userId));
    } catch (Exception $e) {
        // Ignoră eroarea dacă utilizatorul există deja
    }

    // Înregistrează vizualizarea produsului din recomandare
    try {
        $client->send(new Reqs\AddDetailView($userId, $itemId, [
            'cascadeCreate' => true
        ]));
    } catch (Exception $e) {
        die("Eroare Recombee: " . $e->getMessage());
    }
}
        // Display products
        $counter = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            if ($counter % 3 == 0) {
                echo '<div class="section group" style="display:flex; justify-content:center;">';
            }
            ?>
            
                <div class="product-card col-md-4" style="font-family:'Times New Roman'; border:0px; background-color:#f1f1f1; margin:0.5%; border-radius:5px; padding:60px; text-align:center; position:relative;">
                    
                  <a href="preview.php?pid=<?php echo $row['prod_id']; ?>">
            <img src="<?php echo $row['prod_image']; ?>" style="width:300px; height:300px" class="img-responsive" />
        </a>
        <h3 class="text-info" style="color:#800080;font-size:1.4em;"> <?php echo $row['prod_name']; ?> </h3>
        <span class="price text-danger"> <?php echo '$' . $row['prod_price']; ?> </span>
        <div class="button">
            <span>
                <a href="preview.php?pid=<?php echo $row['prod_id']; ?>" class="details" style="color:#800080;">Details</a>
            </span>
        </div>
    </div>
            <?php
            $counter++;
            if ($counter % 3 == 0) {
                echo '</div>';
            }
        }
        // Close the last row if necessary
        if ($counter % 3 != 0) {
            echo '</div>';
        }
        ?>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".product-card");
    const screenWidth = window.innerWidth;

    cards.forEach(card => {
        if (screenWidth <= 1000) {
            card.style.width = "100%";
        } else if (screenWidth <= 1500) {
            card.style.width = "48%";
            card.style.position="center";
        } else {
            card.style.width = "32%";
        }
    });
});
</script>
 <script>
    document.addEventListener("DOMContentLoaded", function () {
        const productCards = document.querySelectorAll(".col-md-4");

        productCards.forEach(card => {
            card.addEventListener("mousedown", function () {
                // Elimină clasa de la toate celelalte carduri
                productCards.forEach(c => c.classList.remove("active-border"));
                // Adaugă clasa doar la cel apăsat
                card.classList.add("active-border");
            });

            // Dacă vrei să dispară efectul când dai drumul la click:
            card.addEventListener("mouseup", function () {
                setTimeout(() => {
                    card.classList.remove("active-border");
                }, 200); // dispare după 0.2 secunde
            });
        });
    });
</script>

<?php include 'footer.php'; ?>
