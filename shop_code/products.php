<?php
include 'header.php';
include 'conectare.php';

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
<!-- JavaScript for Changing the Button Image -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const favoriteButtons = document.querySelectorAll('.favorite-btn');

        favoriteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const prodId = this.getAttribute('data-id'); // Get product ID
                const userId = <?php echo isset($_SESSION['id']) ? intval($_SESSION['id']) : 'null'; ?>; // Get user ID (check if user is logged in)

                if (userId) {
                    // Perform AJAX request to add product to favorites
                    $.ajax({
                        url: 'add_to_favorites.php',
                        method: 'POST',
                        data: { prod_id: prodId, u_id: userId },
                        success: function (response) {
                            console.log(response); // 
                        },
                        error: function () {
                            alert('Error adding product to favorites.');
                        }
                    });

                    // Change the image source to indicate favorite
                    const icon = this.querySelector('.favorite-icon');
                    if (icon) {
                        icon.src = 'images/heart_icon_f.png';
                    }
                } else {
                    alert('You need to log in to add favorites.');
                }
            });
        });
    });
</script>


<div class="main" data-page-type="overview">
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $results_per_page = 6;
    $categories = [
        'coliere' => 'Necklaces',
        'bratari' => 'Bracelets',
        'inele' => 'Rings',
        'cercei' => 'Earrings'
    ];
    
    $materials = [
        'aurgalben' => 'Yellow Gold',
        'auralb' => 'White Gold',
        'aurroz' => 'Pink Gold',
        'argintalb' => 'White Silver',
        'argintgalben' => 'Yellow Silver',
        'argintroz' => 'Pink Silver'
    ];
    
    $condition = "";
    if (isset($_GET['info'])) {
        $info = $_GET['info'];
        if (array_key_exists($info, $categories)) {
            $condition = "WHERE prod_category = '" . $categories[$info] . "'";
        } elseif (array_key_exists($info, $materials)) {
            $condition = "WHERE prod_material = '" . $materials[$info] . "'";
        }
    }
    
    // Calculare paginare
    $sql_count = "SELECT COUNT(*) AS total FROM produse $condition";
    $result_count = mysqli_query($conectare, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $number_of_results = $row_count['total'];
    $number_of_pages = ceil($number_of_results / $results_per_page);

    // Setare pagina curentă
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $this_page_first_result = ($page - 1) * $results_per_page;

    // Selectare produse
    $sql = "SELECT * FROM produse $condition LIMIT $this_page_first_result, $results_per_page";
    $result = mysqli_query($conectare, $sql);
    
    if (!$result) {
        die("Eroare SQL: " . mysqli_error($conectare));
    }
    
  while ($row = mysqli_fetch_assoc($result)) {
    $is_favorite = false;

    if (isset($_SESSION['id'])) {
        $u_id = intval($_SESSION['id']);
        $prod_id = intval($row['prod_id']);

        // Check if product is in favorites
        $check_sql = "SELECT * FROM favorites WHERE u_id = $u_id AND prod_id = $prod_id";
        $check_result = mysqli_query($conectare, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $is_favorite = true;
        }
    }
    ?>
               <div class="product-card col-md-4" style="font-family:'Times New Roman'; border:0px; background-color:#f1f1f1; margin:0.5%; border-radius:5px; padding:60px; text-align:center; position:relative;">

        <!-- Favorite Button Positioned at the Top-Right -->
        <button class="favorite-btn" data-id="<?php echo $row['prod_id']; ?>" style="position:absolute; top:10px; right:10px; border:none; background:none; cursor:pointer;">
            <img src="images/<?php echo $is_favorite ? 'heart_icon_f.png' : 'heart_icon.png'; ?>" alt="Add to favorites" class="favorite-icon" style="width:20px; height:20px;">
        </button>
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
}
    ?>
    <div class="clear"></div>
</div>

<div align="center" style="font-size:20px; margin-top:20px;">
    <?php
    echo "Page: ";
    for ($p = 1; $p <= $number_of_pages; $p++) {
        $link = "products.php?page=$p" . (isset($_GET['info']) ? "&info={$_GET['info']}" : "");
        echo '<a href="' . $link . '">' . $p . '</a> ';
    }
    ?>
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
    
    
    document.addEventListener('DOMContentLoaded', function () {
    const favoriteButtons = document.querySelectorAll('.favorite-btn');

    favoriteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const prodId = this.getAttribute('data-id'); // Preia ID-ul produsului
            const userId = <?php echo isset($_SESSION['id']) ? intval($_SESSION['id']) : 'null'; ?>; // Preia ID-ul utilizatorului

            if (userId) {
                // Perform AJAX request to add bookmark to Recombee
                $.ajax({
                    url: 'add_bookmark.php',
                    method: 'POST',
                    data: { prod_id: prodId, u_id: userId },
                    success: function (response) {
                        console.log(response); // Debugging (opțional)
                    },
                    error: function () {
                        alert('Error sending bookmark interaction.');
                    }
                });

                // Schimbă iconița pentru favorite
                const icon = this.querySelector('.favorite-icon');
                if (icon) {
                    icon.src = 'images/heart_icon_f.png';
                }
            } else {
                alert('You need to log in to add favorites.');
            }
        });
    });
});

</script>



<?php include 'footer.php'; ?>
