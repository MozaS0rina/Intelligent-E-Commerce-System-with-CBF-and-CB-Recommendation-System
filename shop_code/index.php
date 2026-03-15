<?php
require 'vendor/autoload.php';
include 'header.php';
include 'conectare.php';

use Recombee\RecommApi\Client as RecombeeClient;
use Recombee\RecommApi\Requests\RecommendItemsToUser;

// Check if the user is logged in
$is_logged_in = isset($_SESSION['id']); // Assuming user ID is stored in the session

?>
<style>
.active-border {
    box-shadow: 0 0 15px 5px rgba(128, 0, 128, 0.5);
    border: 2px solid #800080;
    transition: all 0.3s ease;}

}
</style>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<div class="header_bottom">
    <div><img src="images/indexphoto.jpg" style="margin-top:2%"></div>
</div>

<!-- Recommended Products Widget -->
<div class="main" data-page-type="overview">
    <h1 style="font-size:36px; text-align:left; margin-left:20px; color:#800080;">Our Top Picks for You</h1>
    
        <?php
        $is_logged_in = isset($_SESSION['id']);
        if ($is_logged_in) {
            // If user is logged in, fetch recommendations from Recombee
          
$client = new RecombeeClient('RECOMBEE_DB', 'RECOMBEE_KEY',
                             ['region' =>'RECOMBEE_REGION'], ['verify' => false]);

            $count = 3; // Number of recommendations
            $userId = strval($_SESSION['id']); // Convert user ID to string
            try {
                $result = $client->send(new RecommendItemsToUser($userId, $count, ['scenario' => 'home_page', 'cascadeCreate' => true]));
                $recommendedIds = $result['recomms']; // Recommended items from Recombee
            } catch (Exception $e) {
                die('Error fetching recommendations from Recombee: ' . $e->getMessage());
            }

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

<div class="header_bottom_left">
			<div class="section group">
				<div class="listview_1_of_2 images_1_of_2">
					<div >
						<a href="products.php?info=cercei"><img src="images/silverearings.jpg" style="width: 300px; height: 160px" / ></a>						
					</div>
				   
			   </div>			
				<div class="listview_1_of_2 images_1_of_2">
					<div >
						  <a href="products.php?info=coliere"><img src="images/necklacegold.jpg" style="width: 300px; height: 160px" / ></a>
					</div>
					
				</div>
			</div>
			<div class="section group">
				<div class="listview_1_of_2 images_1_of_2">
					<div>
						 <a href="products.php?info=argintalb"> <img src="images/silverset.jpg" style="width: 300px; height: 160px" /></a>
					</div>
				    
			   </div>			
				<div class="listview_1_of_2 images_1_of_2">
					<div >
						  <a href="products.php?info=inele"><img src="images/goldrings.jpg" style=" height: 160px" /></a>
					</div>
					
				</div>
			</div>
		  <div class="clear"></div>
		</div>
			 <div class="header_bottom_right_images">
		   <!-- FlexSlider -->
              <section class="slider">
				  <div class="flexslider">
					<ul class="slides">
						<li><img src="images/pinkgoldring.jpg" alt=""/></li>
						<li><img src="images/silversetnecklace.jpg" alt=""/></li>
						<li><img src="images/pinkgoldset.jpg" alt=""/></li>
						<li><img src="images/goldearings.jpg" alt=""/></li>
				    </ul>
				  </div>
	      </section>
<!-- FlexSlider -->
	    </div>
	  <div class="clear"></div>
  </div>	


  <br>
  
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

<?php
	include 'footer.php';

