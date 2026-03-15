<?php
include 'header.php';
include 'conectare.php';
require 'vendor/autoload.php';
	
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


<div class="main" data-page-type="overview">
    
    
<h1 style="text-align:center; color:#800080; font-size:36px; margin-bottom:20px;">Your Favorite Products</h1>
    
        <?php
        // Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo "<p style='text-align:center; color:#800080; font-size:20px;'>Please log in to view your favorites.</p>";
    include 'footer.php';
    exit();
}

$user_id = intval($_SESSION['id']); // Safely retrieve user ID

// Query to fetch favorite products
$sql = "SELECT p.prod_id, p.prod_name, p.prod_price, p.prod_image
        FROM produse p
        INNER JOIN favorites f ON p.prod_id = f.prod_id
        WHERE f.u_id = $user_id";

$result = mysqli_query($conectare, $sql);

if (!$result) {
    die("SQL Error: " . mysqli_error($conectare));
}
        if (mysqli_num_rows($result) > 0) {
            $counter = 0; // Initialize counter to track products per row
           

            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="product-card col-md-4" style="font-family:'Times New Roman'; border:0px; background-color:#f1f1f1; margin:0.5%; border-radius:5px; padding:60px; text-align:center; position:relative;">
                    <!-- Delete Button Positioned at the Top-Right -->
                    <button class="favorite-btn" data-id="<?php echo $row['prod_id']; ?>" style="position:absolute; top:10px; right:10px; border:none; background:none; cursor:pointer;">
                        <img src="images/delete.png" alt="Remove from favorites" class="favorite-icon" style="width:20px; height:20px;">
                    </button>
                    
                  <a href="preview.php?pid=<?php echo $row['prod_id']; ?>">
                    <img src="<?php echo $row['prod_image']; ?>" style="width:300px; height:300px" class="img-responsive" />
                    </a>
                <h3 class="text-info" style="color:#800080;"> <?php echo $row['prod_name']; ?> </h3>
                <span class="price text-danger"> <?php echo '$' . $row['prod_price']; ?> </span>
                <div class="button">
                    <span>
                        <a href="preview.php?pid=<?php echo $row['prod_id']; ?>" class="details" style="color:#800080;">Details</a>
                    </span>
                </div>
            </div>
                <?php
                $counter++; // Increment counter

                
            }

            
        } else {
            echo "<p style='text-align:center; color:#800080; font-size:20px;'>No favorite products found!</p>";
        }
        ?>
        <div class="clear"></div>
   
</div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const favoriteButtons = document.querySelectorAll(".favorite-btn");

        favoriteButtons.forEach(button => {
            button.addEventListener("click", function () {
                const prodId = this.getAttribute("data-id");

                fetch("remove_favorite.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "prod_id=" + prodId
                })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "success") {
                        this.closest(".col-md-4").remove();
                    } else {
                        alert("Error removing product from favorites.");
                    }
                })
                .catch(() => alert("An error occurred."));
            });
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



<?php include 'footer.php'; ?>
