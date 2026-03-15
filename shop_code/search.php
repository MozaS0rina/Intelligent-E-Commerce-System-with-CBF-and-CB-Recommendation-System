<?php
  include 'header.php';
  include 'conectare.php';
?>

<meta http-equiv="Content-Type" content="text/html; char=utf-8" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<br>

<?php

$sql="SELECT * FROM produse";
//$output='';
//collect
if(isset($_POST['search']))
{
    $searchq = mysqli_real_escape_string($conectare, $_POST['search']);

    $results_per_page = 6; //numarul de produse afisate pe o pagina
    if(!isset($_GET['page'])){
        $page = 1;
    }else{
        $page = $_GET['page'];
    }

    $this_page_first_result = ($page - 1) * $results_per_page;

    $sql = "SELECT * FROM produse WHERE prod_name LIKE '%$searchq%' OR prod_material LIKE '%$searchq%' LIMIT $this_page_first_result, $results_per_page";

    $result = mysqli_query($conectare, $sql);
    $number_of_results = mysqli_num_rows($result);

    $number_of_pages = ceil($number_of_results / $results_per_page);

    if(mysqli_num_rows($result) == 0){
        echo 'There were no search results!';
    }else{
        while($row = mysqli_fetch_array($result)){
            ?>
            <div class="col-md-4" style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:40px;" align="center">
                <a href="preview.php?pid=<?php echo $row['prod_id']; ?>"><img src="<?php echo $row['prod_image'] ?>" style="width:300px; height:300px" class="img-responsive"/></a>
                <h3 class="text-info"style="color:#800080;"><?php echo $row['prod_name']  ?></h3>
                <p><span class="strike"></span><span class="price" class="text-danger"><?php echo '  $'.$row['prod_price']  ?></span></p>
               
                <div class="button"><span><a href="preview.php?pid=<?php echo $row['prod_id']; ?>" class="details" style="color:#800080;">Details</a></span></div>
            </div>

            <?php
        }
    }

}
?>

<div class="clear"></div>


<div align="center">
    <?php
    echo "Page: ";
    for ($page = 1; $page <= $number_of_pages; $page++) {
        echo '<a href="products.php?page=' . $page . '" >' . $page . '</a> ';
    }
    ?>
</div>
<br><br>

<?php
  include 'footer.php';
?>