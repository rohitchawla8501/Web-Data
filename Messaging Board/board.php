<?php//require "login.php"; ?>
<html>
<head><title>Message Board</title></head>
<body>






<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
error_reporting(E_ALL);
ini_set('display_errors','On');

session_start();
 $dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
 
function display()
	 {
		if(!isset($_GET['logout']))
		{
		
		$dbh1 = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		$stmt1=$dbh1->prepare('select * from posts,users where posts.postedby=users.username order by datetime DESC ');
        $stmt1->execute();
        //$stmt2=dbh1->prepare('select id from posts');              
echo("<table border='2'><th>ID</th><th>USERNAME</th><th>FullName</th><th>DATETIME</th><th>ReplyTo</th><th>MEssage</th><th>Button</th>");
		
		while($row=$stmt1->fetch()){
	
	//echo($row['id']."    ".$row['replyto']."   ".$row['postedby']."   ".$row['datetime']."   ".$row['message']);

	//echo("<tr><td>".$row['id']."</td>"."<td> ". $row['username']."</td><td> ". $row['fullname']."</td><td> ". $row['datetime']."</td><td> ".$row['replyto']."</td><td> ".$row['message']."</td><td><form action='board.php?replyto=".$row['id']/*$uid*/."' method=POST><input type=submit value=".$row['id'].">Replyto</input></form></td></tr>");
	echo("<tr><td>".$row['id']."</td>"."<td> ". $row['username']."</td><td> ". $row['fullname']."</td><td> ". $row['datetime']."</td><td> ".$row['replyto']."</td><td> ".$row['message']."</td><td><button type=submit name='Replyto' value='".$row['id']."'>Replyto</button></td></tr>");
	//echo("<tr><td> ". $row['id']."</td><td> ". $row['replyto']."</td><td> ". $row['postedby']."</td><td> ".$row['datetime']."</td><td> ".$row['message']."</td><td> <button type=submit value=".$row[id]." name='replyto'>replyto</button></td></tr>");
	
	}		
			 
	echo("</table>");	 
		}
	 }

if (isset($_SESSION["username"])) { 
?>        
<form action=board.php method=GET name='f'>
<textarea name="area"  rows=10 cols=30 id='arr' ></textarea>
<input type=submit value='New Post' name='post' />
<button type=submit  value='1' name='logout'>LOGOUT</button>
		
<?php $User = $_SESSION["username"];
         echo "Logged In User: ", $User, "<br />";

	
		 
		 if(isset($_GET['post']))
	 {
		 $uid=(string)uniqid();   
        
		
		// echo($uid);
 
	

        
		try {
 
  $stmt=$dbh->prepare('insert into  posts values("'.$uid.'","NULL","'.$_SESSION["username"].'", now(),"'.$_GET["area"].'")');
  $stmt->execute();

  
  } 
 catch (PDOException $e) {
  print "Error!: " . $e->POSTMessage() . "<br/>";
  
}
		 
	
	/*
		$stmt1=$dbh->prepare('select * from posts ');
        $stmt1->execute();
                      
echo("<table>");
while($row=$stmt1->fetch()){
	
	echo("<tr><td>".$row['id']."</td><td>".$row['replyto']."</td><td>".$row['postedby']."</td><td>".$row['datetime']."</td><td>".$row['message']."</td><td><form action='board.php?replyto=".$uid."' method=post><input type=submit value='Reply'></input></form></td></tr>");

	}		
		
		
echo("</table>");*/		
				
		 display();
		
	
	 }
	 else{
		if(isset($_GET['Replyto']))
		{}	
	else{
	display();
	 }
	 }

//----------------------------------------------------------------------------	 

	 if(isset($_GET['Replyto']))
	 {
		
		 
		 $uid=(string)uniqid();   
		try {
    //echo($_POST['area']);
  $stmt=$dbh->prepare('insert into  posts values("'.$uid.'","'.$_GET['Replyto'].'","'.$_SESSION["username"].'", now(),"'.$_GET['area'].'")');
  $stmt->execute();

  
  } 
 catch (PDOException $e) {
  print "Error!: " . $e->POSTMessage() . "<br/>";
  
}
	
		 //echo("inreplyto");
		 //echo($_POST['Replyto']);
	     display();
		 
	 

	/* if($_SESSION['flag']==0)
	 {
		 display();
		$_SESSION['flag']=$_SESSION['flag']+1;
	 }*/
	 }
	 }	
	else {
         echo( " NOT AUTHORIZED");
     }
//------------------------------------------------------------------------------------------------------------------------------------------
	 if (isset($_GET['logout']))
{
	//echo("in logout");
	unset($_SESSION['username']);
	//unset($_SESSION['flag']);
	//error_reporting(E_ERROR | E_PARSE);
	//exit();
	header("Location:login.php");
	 }
	 
	 
	
?>
</form> 
</body>
</html>
