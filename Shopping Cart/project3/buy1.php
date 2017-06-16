<!DOCTYPE html>
<html>
<head><title>Buy Products</title></head>
<body>
<?php
if(isset($_POST['f']) )
{
echo $_POST['f'];
}
else {
	echo "no data";
}
if(isset($_GET['buy']) )
{
	echo ($_GET['buy']);
}
else{
	echo("Not working");
}
?>
</body>
<html>

