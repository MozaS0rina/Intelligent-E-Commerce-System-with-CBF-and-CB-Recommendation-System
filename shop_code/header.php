<?php
	session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Royal Radiance</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/menu.css" rel="stylesheet" type="text/css" media="all"/>
<script src="js/jquery.min.js"></script>
<script src="js/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript">
    function loadGoogleTranslateScript() {
        if (!document.querySelector('script[src*="translate_a/element.js"]')) {
            var script = document.createElement("script");
            script.type = "text/javascript";
            script.src = "//translate.google.com/translate_a/element.js?cb=googleTranslateInit";
            document.body.appendChild(script);
        } else {
            googleTranslateInit(); // dacă e deja încărcat
        }
    }

    function googleTranslateInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'ro',
            autoDisplay: false
        }, 'google_translate_element');
    }

    function googleTranslate(language) {
        localStorage.setItem("selectedLanguage", language);
        loadGoogleTranslateScript();

        setTimeout(function () {
            var select = document.querySelector("select.goog-te-combo");
            if (select) {
                select.value = language;
                select.dispatchEvent(new Event("change"));
            }
        }, 1000);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const savedLanguage = localStorage.getItem("selectedLanguage");
        if (savedLanguage === "ro") {
            googleTranslate("ro");
        }
    });
</script>
</head>
<body>

  <div class="wrap">
	<div class="header">
		<div class="header_top">
			<div class="logo">
				<a href="index.php"><img src="images/logo.png" alt="" /></a>
			</div>
			  <div class="header_top_right">
			    <div class="search_box">
				    <form action="search.php" method="POST">
				    	<input type="text" name="search" placeholder="Search for Jewelry">
				    	<input type="submit"  value="SEARCH" >
				    </form>
			    </div>
			    <div class="shopping_cart">
					<div class="cart">
						<a href="cart_page.php" title="View my shopping cart" rel="nofollow">
							<strong class="opencart"> </strong>
							<span class="cart_title">Cart</span>
							<?php 
								include 'conectare.php';
								$count_q = 0;
								$sql="SELECT * FROM cumparaturi";
								$result = mysqli_query($conectare, $sql);
								while ($row = mysqli_fetch_assoc($result)) {
									$count_q += $row['c_qty'];
								}
								echo $count_q;
							?>
						</a>
					</div>
			      </div>
			      
      <button onclick="googleTranslate('ro')" style="cursor:pointer; margin:0.5%">RO</button>
<div id="google_translate_element" style="display:none;"></div>
        
			
		   <div class="login" action="login.inc.php">
		   		<?php
		   			if (isset($_SESSION['id'])) {
		        		echo '<span><a href="logout.inc.php"><p style="text-align: center; color: green; font-size: 15px;">'.$_SESSION['username'];
		           	}else{
		        		echo '<span><a href="login.php"><img src="images/login.png" alt="" title="login"/></a></span>';
		        	}
		   		?>
		   	   
		   </div>
		 <div class="clear"></div>
	 </div>
	 <div class="clear"></div>
 </div>

 <div class="h_menu" align="center" >
 <a id="touch-menu" class="mobile-menu" href="#">Menu</a>
 <nav >
 <ul class="menu list-unstyled" >
	<li><a href="index.php">HOME</a></li>
	<li><a href="products.php">JEWELRY</a> 
		<ul class="sub-menu list-unstyled sub-menu2">
			<div class="navg-drop-main">
				<div class="nav-drop nav-top-brand"> 
					<li><a href="products.php?info=coliere">NECKLACES</a></li>
					<li><a href="products.php?info=bratari">BRACELETS</a></li>
					<li><a href="products.php?info=inele">RINGS</a></li>
					<li><a href="products.php?info=cercei">EARRINGS</a></li>
				</div> 
			</div>
		</ul>
	</li>
	<li><a href="products.php">MATERIAL</a>
		<ul class="sub-menu list-unstyled sub-menu2">
			<div class="navg-drop-main">
				<div class="nav-drop nav-top-brand"> 
					<li><a href="products.php?info=aurgalben">YELLOW GOLD</a></li>
					<li><a href="products.php?info=aurroz">PINK GOLD</a></li>
					<li><a href="products.php?info=auralb">WHITE GOLD</a></li> 
					<li><a href="products.php?info=argintalb">WHITE SILVER</a></li>
					<li><a href="products.php?info=argintroz">PINK SILVER</a></li>
					<li><a href="products.php?info=argintgalben">YELLOW SILVER</a></li>
				</div> 
			</div>
		</ul>
	</li> 
	<?php
		if (isset($_SESSION['id']) && $_SESSION['username'] == 'admin') {
	?>
	<li><a href="afisare_produse.php">Edit Products</a>
		<ul class="sub-menu list-unstyled sub-menu2">
			<div class="navg-drop-main">
				<div class="nav-drop nav-top-brand"> 
					<li><a href="afisare_produse.php">Show Products</a></li>
					<li><a href="add_product.php">Add Products</a></li>
					<li><a href="edit_product.php">Edit Products</a></li> 
				</div> 
			</div>
		</ul>
	</li>
	<li><a href="#">Show</a>
		<ul class="sub-menu list-unstyled sub-menu2">
			<div class="navg-drop-main">
				<div class="nav-drop nav-top-brand"> 
					<li><a href="afisare_utilizatori.php">Show Users</a></li>
					<li><a href="afisare_istoric.php">History</a></li> 
				</div> 
			</div>
		</ul>
	</li>
	<?php
		}
	?>
	<li><a href="favorites.php">FAVORITES</a></li>
	<li><a href="contact.php">CONTACT</a></li>
	<div class="clear"> </div>
</ul>
</nav> 
<script src="js/menu.js" type="text/javascript"></script>
</div>