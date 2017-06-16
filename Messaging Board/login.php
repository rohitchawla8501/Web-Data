
<html>
<head><title>Message Board</title></head>
<body>
<h1>LOGIN </h1>
<form action=login.php method=POST>
USERNAME <input type=text name= "username"/></br>
PASSWORD <input type=password  name="password"  /></br>

<input type=submit value=LOGIN />


</form>
<?php
if (isset($_POST['username']))
{
	try{
	$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	$dbh->exec('delete from users where username="rohit"');
	$dbh->exec('insert into users values("rohit","' . md5("rohit") . '","Rohit Chawla","rohit@cse.uta.edu")');
	
	$stmt=$dbh->prepare("select * from users");
    $stmt->execute();
	//$result = $stmt->fetch(PDO::FETCH_ASSOC);
	//echo($result['username']);
	while ($row = $stmt->fetch()) {
    //print_r($row);
	$user=(string)$row['username'];
	$pass=(string)$row['password'];
	//echo($user);
	if($user==$_POST['username']&& $pass==md5($_POST['password']) )
	{
		session_start();
		$_SESSION["username"]=$user;
		//$_SESSION["flag"]=0;
		//echo('Entered');
		echo('Logged in successfully');
        header("Location:board.php");	
	}
  }
	}	
catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  
}
}

?>
</body>


</html>