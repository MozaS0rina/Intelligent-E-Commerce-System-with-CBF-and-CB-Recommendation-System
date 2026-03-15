<?php
	include 'header.php';
	include 'conectare.php';
?>

<!--
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
 
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
-->

	<div id="upload_products">
		<form name="add_product" action="" method="POST" enctype="multipart/form-data" >
			<table>
				<tr>
					<td style="font-weight:bold; font-size:20px;" >Product Name</td>
					<td><input type="text" name="pname" style="margin-top:20px; font-size:20px; margin-left:50px;" ></td>						
				</tr>
				<tr>
					<td style="font-weight:bold; font-size:20px;">Product Material</td>
					<td><input type="text" name="pmaterial" style="margin-top:10px;font-size:20px; margin-left:50px;"></td>						
				</tr>
				<tr>
					<td style="font-weight:bold; font-size:20px;">Product Price</td>
					<td><input type="text" name="pprice" style="margin-top:10px;font-size:20px; margin-left:50px;"></td>						
				</tr>
				<tr>
					<td style="font-weight:bold; font-size:20px;">Product Quantity</td>
					<td><input type="text" name="pqty" style="margin-top:10px;font-size:20px; margin-left:50px;"></td>						
				</tr>
				<tr>
					<td style="font-weight:bold; font-size:20px;">Product Description</td>
					<td><textarea cols="15" rows="5" name="pdesc" style="margin-top:10px;font-size:20px; margin-left:50px;"></textarea></td>						
				</tr>
				<tr>
					<td style="font-weight:bold; font-size:20px;">Product Specification</td>
					<td><textarea cols="15" rows="5" name="pspec" style="margin-top:10px;font-size:20px; margin-left:50px;"></textarea></td>						
				</tr>
				<tr>
					<td style="font-weight:bold; font-size:20px;">Product Image</td>
					<td><input type="file" name="pimage"style="margin-top:10px;font-size:20px; margin-left:50px;"></td>						
				</tr>
				<tr>
					<td style="font-weight:bold; font-size:20px;">Product Category</td>
					<td><select name="pcategory" style="margin-top:10px;font-size:20px; margin-left:50px;">
						<option value="Earrings" >Earrings</option>
						<option value="Bracelets">Bracelets</option>
						<option value="Rings">Rings</option>
						<option value="Necklaces">Necklaces</option>
					</select></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" name="submit1" value="UPLOAD" style="font-family:'Times New Roman';background:#800080;color:white;margin-top:10px;margin-bottom:10px;margin-right:120px;font-size:20px; margin-left:50px;"></td>
				</tr>
			</table>
		</form>
<?php
	if (isset($_POST['submit1'])) {
		$v1 = rand(1111, 9999);
		$v2 = rand(1111, 9999);
		//print($v1);
		//print($v2);
		$v3 = $v1.$v2;
		$v3 = md5('$v3');

		$fnm = $_FILES['pimage']['name'];
		$dst = "./product_image/".$v3.$fnm;
		$dst1 = "product_image/".$v3.$fnm;
		move_uploaded_file($_FILES['pimage']['tmp_name'], $dst);

		mysqli_query($conectare, "INSERT INTO produse (prod_name, prod_material, prod_price, prod_qty, prod_desc, prod_spec, prod_image, prod_category) VALUES('$_POST[pname]', '$_POST[pmaterial]', $_POST[pprice], $_POST[pqty], '$_POST[pdesc]', '$_POST[pspec]', '$dst1', '$_POST[pcategory]')");
	}
?>

	</div>


<?php
	include 'footer.php';
