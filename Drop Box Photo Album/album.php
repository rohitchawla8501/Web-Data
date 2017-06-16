<?php?>
<!DOCTYPE html>
<html>
<body>

<form action="album.php" method="post" enctype="multipart/form-data" >
    SELECT A FILE
    <input type="file" name="fileToUpload" id="fileToUpload" >
    <input type="submit" value="Upload Image" name="submit"></br></br>

<img src="" id='image' style="width:304px;height:228px";/>




<script>
function display(c)
{
	
	document.getElementById("image").src=c;
	}


</script>



<?php
// display all errors on the browser

error_reporting(E_ALL);
//ini_set('display_errors','On');

require_once("DropboxClient.php");


$dropbox = new DropboxClient(array(
	'app_key' =>"",      // Put your Dropbox API key here
	'app_secret' =>"",   // Put your Dropbox API secret here
	'app_full_access' => false,
),'en');


$access_token = load_token("access");
if(!empty($access_token)) {
	$dropbox->SetAccessToken($access_token);
	echo "loaded access token:";
	print_r($access_token);
}
elseif(!empty($_GET['auth_callback'])) // are we coming from dropbox's auth page?
{
	// then load our previosly created request token
	$request_token = load_token($_GET['oauth_token']);
	if(empty($request_token)) die('Request token not found!');
	
	// get & store access token, the request token is not needed anymore
	$access_token = $dropbox->GetAccessToken($request_token);	
	store_token($access_token, "access");
	delete_token($_GET['oauth_token']);
}
if(!$dropbox->IsAuthorized())
{
	// redirect user to dropbox auth page
	$return_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?auth_callback=1";
	$auth_url = $dropbox->BuildAuthorizeUrl($return_url);
	$request_token = $dropbox->GetRequestToken();
	store_token($request_token, $request_token['t']);
	die("Authentication required. <a href='$auth_url'>Click here.</a>");
}

if(isset($_POST["submit"])) {


//   $dropbox->UploadFile("leonidas.jpg");
//echo "EMPTY"  ;
  $uploadname=$_FILES["fileToUpload"]["name"];
$FileType = pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION); 
 echo($FileType);
 if($FileType=="jpg" || $FileType=="jpeg")
 {
$dropbox->UploadFile($_FILES["fileToUpload"]["tmp_name"],$uploadname);
  $files = $dropbox->GetFiles("",false);
}
else{echo("FILE TYPE NOT JPG");}

}	
	
	
	//$dropbox->UploadFile($_FILES["fileToUpload"]);	
	$files = $dropbox->GetFiles("",false);
$file = reset($files);//points to first element ,try using for each also	
	
echo("<table border=2><tr><th>NAME</th><th>LINK</th><th>DELETE</th></tr>");
	foreach($files as $x)
{
	//$test_file = "test_download_".basename($x->path);

	$h=$dropbox->GetLink($x,false);
	
    
	echo ("<tr><td>".$x->path."</td><td><a href='album.php?h=".$h."&p=".$x->path."' name='h'>".$h."</a></td>");
	 //echo("<td><button type=submit name='delete' value='".$x->path."'>delete</button></td></tr>");
echo("<td><input type=button onclick=location.href='album.php?delete=".$x->path."'; value=delete /></td></tr>");
}
echo("</table>");
if(isset($_GET["delete"]))
{
	$f = $dropbox->GetFiles("",false);
	$p= $_GET['delete'];
	foreach($f as $search)
{
	if($search->path == $p)
	{$foundfile=$search;
    //$test_file = "test_download_".basename($foundfile->path);
	$m=$dropbox->Delete($foundfile);
 }
header("Location:album.php");	
	
//print_r($foundfile);
	}	
	
	
}
	
if(isset($_GET['h']))
{
	$foundfile="";
	$p= $_GET['p'];
	$f = $dropbox->GetFiles("",false);
    //print_r($f);	
	foreach($files as $search)
{
	if($search->path == $p)
	{$foundfile=$search;
    $test_file = "test_download_".basename($foundfile->path);
	$m=$dropbox->DownloadFile($foundfile,$test_file);
     }
	
	

	}
	
	$y=$_GET['h'];
	
	<script> 
	var x= "<?php echo $y;?>";
	         display(x);
	</script>
	<?php
}	
 

function store_token($token, $name)
{
	if(!file_put_contents("tokens/$name.token", serialize($token)))
		die('<br />Could not store token! <b>Make sure that the directory `tokens` exists and is writable!</b>');
}

function load_token($name)
{
	if(!file_exists("tokens/$name.token")) return null;
	return @unserialize(@file_get_contents("tokens/$name.token"));
}

function delete_token($name)
{
	@unlink("tokens/$name.token");
}





function enable_implicit_flush()
{
	@apache_setenv('no-gzip', 1);
	@ini_set('zlib.output_compression', 0);
	@ini_set('implicit_flush', 1);
	for ($i = 0; $i < ob_get_level(); $i++) { ob_end_flush(); }
	ob_implicit_flush(1);
	echo "<!-- ".str_repeat(' ', 2000)." -->";
}
?>
</form>
</body>
</html>

