// Put your Last.fm API key here
var api_key = "";
var m=" ";
var x=" ";
function sendRequest () {
    var xhr = new XMLHttpRequest();

    

 var method="artist.getInfo"      
 var artist = encodeURI(document.getElementById("form-input").value);
    xhr.open("GET", "proxy.php?method="+method+"&artist="+artist+"&api_key="+api_key+"&format=json", true);
    xhr.setRequestHeader("Accept","application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            var jsonObj = JSON.parse(xhr.responseText);
                     
x=jsonObj.artist.image[3]['#text']
var str=JSON.stringify(jsonObj,undefined,2);
//var name =JSON.stringify(jsonObj.artist.name,undefined,2);            
m="<h1>"+jsonObj.artist.name+"</h1>";
//var str=xhr.responseText;
//var x = str.getElementsByTagName("CD");            
//var i=0;
//x[i].getElementsByTagName("artist")[0].childNodes[0].nodeValue;
document.getElementById("output").innerHTML = m+'<img src='+jsonObj.artist.image[3]['#text']+'width:42;height:42;>'+'</br>'+'<font size="4" face="arial">'+jsonObj.artist.bio.content+'</br></br>Read More About Artist on Last FM Website: </font>'+'<a href ="'+jsonObj.artist.bio.links.link.href+'">CLICK HERE</a>'; 
 //console.log(jsonObj.artist.bio.links.link.href);   
 }
    };
    xhr.send(null);

var xhr1 = new XMLHttpRequest();
var method1 = "artist.getTopAlbums"
    xhr1.open("GET", "proxy.php?method="+method1+"&artist="+artist+"&api_key="+api_key+"&format=json", true);
    xhr1.setRequestHeader("Accept","application/json");
    xhr1.onreadystatechange = function() {
     if (xhr1.readyState == 4) {
            var jsonObj = JSON.parse(xhr1.responseText);
            //console.log(jsonObj)           
var str=JSON.stringify(jsonObj,undefined,2);
   console.log(jsonObj.topalbums.album);         
var out=" ";

for(var i=1;i<jsonObj.topalbums.album.length;i++)
{
//var //str=JSON.stringify(jsonObj.topalbums.album[i].name,undefined,2);
 //console.log(jsonObj.topalbums.album[i].image[2]['#text']);

 out=out+'<img src='+jsonObj.topalbums.album[i].image[1]['#text']+' width:42;height:42;>'+'<font size="4" face="arial">'+jsonObj.topalbums.album[i].name+'</font><br/>';
//document.getElementById("output1").innerHTML=out;



}

 

document.getElementById("output1").innerHTML="<h3>TOP ALBUMS</h3>"+out;
     
 }
 
    };
    xhr1.send(null);



var xhr2 = new XMLHttpRequest();
var method2 = "artist.getSimilar"
    xhr2.open("GET", "proxy.php?method="+method2+"&artist="+artist+"&api_key="+api_key+"&format=json", true);
    xhr2.setRequestHeader("Accept","application/json");
    xhr2.onreadystatechange = function() {
     if (xhr2.readyState == 4) {
            var jsonObj = JSON.parse(xhr2.responseText);
            //console.log(jsonObj)           
var str=JSON.stringify(jsonObj,undefined,2);
var out=" ";
for(var i=0;i<jsonObj.similarartists.artist.length;i++)
{
	out=out+'</br><font size="4" face="arial">'+jsonObj.similarartists.artist[i].name+'</font>';
}	

 // console.log(jsonObj.similarartists.artist[0].name);         


   
 }
 document.getElementById("output3").innerHTML="<pre>"+out+"</pre>";
    };
    xhr2.send(null);










}
