// Put your zillow.com API key here
var zwsid = '';
var address='';
var address1='';
var city='';
var city='';
var request = new XMLHttpRequest();
var request1 = new XMLHttpRequest();
var value;
function initialize () {
}

function displayResult() {
    try{
	if (request.readyState == 4){ 
        var xml = request.responseXML.documentElement;
        		value = xml.getElementsByTagName("zestimate")[0].getElementsByTagName("amount")[0].innerHTML;
        value="$"+value+"";
	document.getElementById("output").innerHTML = value;
	gcinfo(value);
	}
	}
	catch(err){
		gcinfo('No amount ');
		
	}
	
  
}	

function sendRequest(add) {
    request.onreadystatechange = displayResult;
    var add1=JSON.stringify(add,undefined,2);
	console.log(add1);
	var str=add.split(',',3);
	console.log(str[0]);
	console.log(str[1]+" "+str[2]);
	address = document.getElementById("address").value;
     //city = document.getElementById("city").value;
   	request.open("GET","proxy.php?zws-id="+zwsid+"&address="+str[0]+"&citystatezip="+str[1] +" "+str[2]);
    
	request.withCredentials = "true";
    request.send(null);

	}
function sendRequest2(addr) {
    var str=addr[0].formatted_address;
	//console.log(str);
    str=str+" ";
	var str1=str.split(',',3);
	address1=str1[0];
	city1=str1[1]+""+str1[2]
	//console.log(address);
	//console.log(city);
	 
		 request1.onreadystatechange = function () {
		try{
		if (request1.readyState == 4) {
        var xml = request1.responseXML.documentElement;
        value = xml.getElementsByTagName("zestimate")[0].getElementsByTagName("amount")[0].innerHTML;
        value="$"+value+"";
	//console.log(value);
	revinfo(value);
		
	document.getElementById("output").innerHTML = value;
		}
		}
	 catch(err){
			revinfo('No Value Found');
		}
	 }
		
	
	 
    //address = document.getElementById("address").value;
     //city = document.getElementById("city").value;
   	request1.open("GET","proxy.php?zws-id="+zwsid+"&address="+address1+"&citystatezip="+city1);
    request1.withCredentials = "true";
    request1.send(null);
//console.log(value);
	//return(value);
	
		}
	