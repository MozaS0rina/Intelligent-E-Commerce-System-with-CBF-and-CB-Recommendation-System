<?php
	include 'header.php';
	include 'conectare.php';
	require 'vendor/autoload.php';
	use Recombee\RecommApi\Client as RecombeeClient;
	use Recombee\RecommApi\Requests\AddDetailView;
	use Recombee\RecommApi\Requests\AddUser;
	use Recombee\RecommApi\Requests as Reqs;
	use Recombee\RecommApi\Requests\RecommendItemsToItem;


// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']); // Assuming user ID is stored in the session
$dbName='RECOMBEE_DB';
$key='RECOMBEE_KEY';

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>
.active-border {
    box-shadow: 0 0 15px 5px rgba(128, 0, 128, 0.5);
    border: 2px solid #800080;
    transition: all 0.3s ease;}

}
</style>
<?php

	

	if (isset($_GET['pid'])) {
		$sql = sprintf("SELECT * FROM produse WHERE prod_id =  %s", $_GET['pid']);
		$row = mysqli_query($conectare, $sql);
		$product = mysqli_fetch_array($row);
	}
	
   
	if (isset($_POST['add_to_cart'])) {
		if($product['prod_qty'] < $_POST['cantitate']){
			$message = "Sorry, we have left just ".$product['prod_qty']." products!!!";
			echo "<script>alert('$message');</script>";
		}else{
			$sqlc = sprintf("INSERT INTO cumparaturi (c_prod_id, c_qty) VALUES(%s, %s)", $product['prod_id'], $_POST['cantitate']);
			mysqli_query($conectare, $sqlc);
			echo "<script>window.location='cart_page.php'</script>";
		}
		
	}
	



?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

 <div class="main">
    <div class="content" align="center">
    	
    		<div class="clear"></div>
    	</div>
    	<div class="section group" align="center">
				<div class="cont-desc span_1_of_2">				
					<div class="grid images_3_of_2">
						<img src="<?php echo $product['prod_image'] ?>" alt="" />
					</div>
				<div class="desc span_3_of_2">
					<h2><?php echo $product['prod_name'] ?></h2>
					<p><?php echo $product['prod_spec'] ?></p>					
					<div class="price">
						<p>Price: <span><?php echo '$'.$product['prod_price'] ?></span></p>
					</div>
					
				<div>
					<form method="POST">
						<input type="number" name="cantitate" value="1">
						
						<input type="submit" name="add_to_cart" value="Add to Cart" style="font-family:'Times New Roman';background:#800080;color:white;">
					</form>
					<div class="clear"></div>
				</div>
			</div>
			<div class="product-desc">
			<h2>Jewelry Details</h2>
			<p><?php echo $product['prod_desc'] ?></p>
	    </div>


	    <div class="product-desc" class="table-responsive">
			<h2>Jewelry Reviews</h2>
			<table class="table table-bordered">
				<th><b>Username </b></th>
				<th><b>Review </b></th>
				<?php
					$sql = "SELECT * FROM review 
						INNER JOIN utilizatori ON review.r_user_id=u_id WHERE r_prod_id = $_GET[pid]";

						$result = mysqli_query($conectare, $sql);
					
						while ($row=mysqli_fetch_assoc($result))
						 {
							echo "<tr>";
							echo "<td>".$row['u_name']."</td>";
							echo "<td>".$row['r_rev']."</td>";
							echo "</tr>";
						}
					

				?>
			</table>
	    </div>
	    <br>
	    

<?php
	if(isset($_POST['insert_review'])){
		$sql = "INSERT INTO review (r_prod_id, r_user_id, r_rev) VALUES ($_GET[pid], $_SESSION[id], '$_POST[rev_text]')";
		mysqli_query($conectare, $sql);
		?>
			<script>window.location="products.php"</script>
		<?php
	}

?>

	    <form method="POST">
	    	<textarea cols="60" rows="5" name="rev_text"></textarea>
	    	<input type="submit" name="insert_review" value="Add Review" style="font-family:'Times New Roman';background:#800080;color:white;">
	    </form>


	    		
	</div>
				
 	</div>
	</div>
	
<!-- Recommended Products Widget -->
<div class="recommended-widget" style="margin-top:30px;">
    <h1 style="font-size:36px; text-align:left; margin-left:20px; color:#800080;">You might be interested in...</h1>
    <div class="main" data-page-type="overview" style="text-align:left;">
        <?php
        if ($is_logged_in) {
            // If user is logged in, fetch recommendations from Recombee
            $client = new RecombeeClient($dbName,$key ,['region' =>'RECOMBEE_REGION'], ['verify' => false]);

            $count = 3; // Number of recommendations
            $prodId=$_GET['pid'];
            $userId = strval($_SESSION['id']); // Convert user ID to string
            try {
                $result = $client->send(new RecommendItemsToItem($prodId,$userId, $count,
                ['scenario' => 'cart', 'cascadeCreate' => true]));
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
<?php
	include 'footer.php';

	
 
    $client = new RecombeeClient('RECOMBEE_DB', 'RECOMBEE_KEY',
                             ['region' =>'RECOMBEE_REGION'], ['verify' => false]);
   
     $userId=strval($_SESSION['id']);
     $itemId=strval($_GET['pid']);
      try {
    $client->send(new AddUser(strval($_SESSION['id'])));
    
    } catch (Exception $e) {
        //die();
    }

         try {
            $client->send(new Reqs\AddDetailView($userId, $itemId, [
                'cascadeCreate' => true
            ]));
           
        } catch (Exception $e) {
            die();
        }

if(isset($_POST['add_to_cart'])) {
    $userId = strval($_SESSION['id']); // Preia ID-ul utilizatorului
    $itemId = strval($_GET['pid']);    // Preia ID-ul produsului

    // Adaugă utilizatorul (dacă nu există deja)
    try {
        $client->send(new Reqs\AddUser($userId));
    } catch (Exception $e) {
    }
    // Înregistrează interacțiunea "Add to Cart"
    try {
        $client->send(new Reqs\AddCartAddition($userId, $itemId, ['cascadeCreate' => true]));
    } catch (Exception $e) {
        die("Eroare la Recombee: " . $e->getMessage());
    }
}
if(isset($_POST['insert_review'])) {
    $userId = strval($_SESSION['id']); // ID-ul utilizatorului
    $itemId = strval($_GET['pid']);    // ID-ul produsului
    $reviewText = $_POST['rev_text']; // Textul recenziei

    // Înregistrează interacțiunea "Add Review" în Recombee
    try {
        $client->send(new Reqs\AddRating($userId, $itemId,1, [ // Exemplu: valoare implicită pentru rating
            'cascadeCreate' => true // Creează automat utilizatorul/articolul dacă nu există
        ]));
    } catch (Exception $e) {
        die("Eroare Recombee: " . $e->getMessage());
    }

    
}
	
?>
