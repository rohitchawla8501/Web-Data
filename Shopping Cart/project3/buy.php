<!DOCTYPE html>
<html>
<head><title>Buy Products</title></head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
$xmlstr = file_get_contents('http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/GeneralSearch?apiKey=&keyword=samsung+i7');
$xmlstr1=file_get_contents('http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/CategoryTree?apiKey=&visitorUserAgent&visitorIPAddress&trackingId=7000610&categoryId=72&showAllDescendants=true');
$xml = new SimpleXMLElement($xmlstr);
$xml1 = new SimpleXMLElement($xmlstr1);
header('Content-Type: text');

session_start();



?>

<div>

SHOPPING CART
<a href ='buy.php?empty=1'>Clear</br></a>
<?php
if(isset($_POST['f']) ){display();}
$totalprice=0;


function display()
{
if(isset($_SESSION["cart"]))
{
$totalprice=0;
foreach($_SESSION["cart"] as $key=>$v)
{
	echo($_SESSION['cart'][$key]["name"].$_SESSION['cart'][$key]["price"]."<a href=buy.php?remove=".$key.">Remove</a></br>");
    //echo($key);
	$totalprice=$totalprice+$_SESSION['cart'][$key]["price"];
	}
echo('Total Price'.$totalprice);
	}
else{
	
	echo ('SHOPPING CART EMPTY');
}
}
if(isset($_GET['empty']))
{
	unset($_SESSION['cart']);
	
}

if(isset($_GET['buy']))
{
	$xmlproductid=file_get_contents('http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/GeneralSearch?apiKey&visitorUserAgent&visitorIPAddress&trackingId=7000610&productId='.$_GET['buy']);
	$xmlpro = new SimpleXMLElement($xmlproductid);
	
	$productid=(string)$xmlpro->categories->category->items->product['id'];
	$productname=(string)$xmlpro->categories->category->items->product->name;
	$minprice=(string)$xmlpro->categories->category->items->product->minPrice;
	
	$scart=array($productid=>array('name'=>$productname,'proid'=>$productid,'price'=>$minprice));
	if(empty($_SESSION['cart']))
	{	

$_SESSION['cart']=$scart;//This is initially so that the session array takes the form .Later on array_merge it
	
	}
	else{
	
	$_SESSION['cart']=array_merge($_SESSION['cart'],$scart);	
	

	}

	display();
	}



if(isset($_GET['remove']))
{
	foreach($_SESSION["cart"] as $key=>$v)
	{
		if($key==$_GET['remove'])
		{
			unset($_SESSION['cart'][$key]);
			if(empty($_SESSION['cart']))
			{
				unset($_SESSION['cart']);
			}
			
			
		}

	}
	display();

else{
	echo('');
}	
	

?>
</div>
<div>

<form action="buy.php" method="post" >
<select name="f" >
<?php
//display();
echo("</br>CATEGORY");
foreach($xml1->category->categories->category->categories->category as $value)
{
	
?>

<option value="<?php echo $value['id']; ?>" ><?php echo $value->name; ?></option> 
<?php }?>
</select>
<input type="textarea" name="search"></input>
<input type='submit'></input>
</form>
<?php

if(isset($_POST['f']) )
{
//display();
$s1= $_POST['f'];

$s2= $_POST['search'];
//echo($s2);

$xmlstr2=file_get_contents('http://sandbox.api.shopping.com/publisher/3.0/rest/GeneralSearch?apiKey=&visitorUserAgent&visitorIPAddress&trackingId=7000610&categoryId='.$s1.'&keyword='.$s2);

$xml2 = new SimpleXMLElement($xmlstr2);

*/
foreach($xml2->categories->category->items->product as $result)
{
echo ("<a href=buy.php?buy=".$result['id'].">".$result->name."</a>");
echo("     PRICE:  ".$result->minPrice.$result['id'].'</br>');	
}

foreach($xml2->categories->category->items->offer as $result)
{
echo($result->name);	
}

}
else {
	echo "no data";
}

?>

</div>

</body>
</html>
