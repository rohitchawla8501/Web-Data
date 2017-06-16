package xpath;



import java.io.*;
import java.net.URL;
import java.net.URLConnection;
import java.util.Scanner;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.xpath.*;

import org.w3c.dom.Document;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.InputSource;
public class Xpath1 {

	public static void main(String[] args) throws Exception {
		System.out.println("Enter a search key word");
		InputStreamReader ir=new InputStreamReader(System.in);
		BufferedReader br = new BufferedReader(ir);
		String str = null;
		String toconv="<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>";
		try {
			str = br.readLine();
		    str=str.replace(" ","%20");
		System.out.println(str);
		} catch (IOException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
		System.out.println(str);
		
		
		try {
			URL u=new URL("http://sandbox.api.shopping.com/publisher/3.0/rest/GeneralSearch?apiKey&visitorUserAgent&visitorIPAddress&trackingId=7000610&categoryId=72&keyword="+str+"&showAllDescendants=true&numItems=20");
			System.out.println("URL is " + u.toString());
	         System.out.println("protocol is " + u.getProtocol());
	         System.out.println("authority is " + u.getAuthority());
	         System.out.println("file name is " + u.getFile());
	         System.out.println("host is " + u.getHost());
	         System.out.println("path is " + u.getPath());
	         System.out.println("port is " + u.getPort());
	         System.out.println("default port is " + u.getDefaultPort());
	         System.out.println("query is " + u.getQuery());
	         System.out.println("ref is " + u.getRef());
		    URLConnection conn= u.openConnection();
		     //Object x=conn.getContent();
		     //System.out.println(x.toString());
		    InputStream is =conn.getInputStream();
		    BufferedReader br1 = new BufferedReader(new InputStreamReader(is));

	        String line = null;

	        // read each line and write to System.out
	        while ((line = br1.readLine()) != null) {
	            toconv=toconv+line;
	        	//System.out.println("\n"+line);
	        }
		//System.out.println(toconv);
		Document xmldoc=convert(toconv);
	Scanner sc =new Scanner(System.in);
	System.out.println("\n\nEnter choice \n1.Find rate of products higher than 4.5 \n2.Findname and price of products that contain the word sony \n"
			+ "3.Find names of all products whose name contains the word Sony and the price is between $1000 and $2000, inclusive.");	
	int choice=sc.nextInt();
	
	  switch(choice)
	  {
	
	  case 1:
	  eval("/GeneralSearchResponse/categories/category/items/product[./rating[rating>4.5]]/name",xmldoc);
	 break;
	  case 2:
		  
	  eval("/GeneralSearchResponse/categories/category/items/product[name[contains(.,'Sony')]]//name|/GeneralSearchResponse/categories/category/items/product[name[contains(.,'Sony')]]/minPrice",xmldoc);
		break;
		
	  case 3:	
	  eval("/GeneralSearchResponse/categories/category/items/product[name[contains(.,'Sony')] and  ./minPrice<=2000 and ./minPrice>1000]/name",xmldoc);
		break;
		  //eval("/GeneralSearchResponse/categories/category/items/product/*[name()='name']|/GeneralSearchResponse/categories/category/items/product/rating/*[name()='rating']",xmldoc);
	  default:
	  {
		  
		  System.out.println("PLEASE ENTER VALID CHOICE");
	  }
	  }	
	  
	  } catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		

	}
public static Document convert(String str)
{
	//System.out.println(str);
	DocumentBuilderFactory f=DocumentBuilderFactory.newInstance();
	DocumentBuilder builder; 
	
	try 
     {  
         builder = f.newDocumentBuilder();  
         Document doc = builder.parse( new InputSource( new StringReader( str ) ) ); 
//System.out.println((Node)doc.getChildNodes());
        //printDocument(doc, System.out);
         return doc;
     } catch (Exception e) {  
         e.printStackTrace();  
     } 
     return null;
}


static void eval ( String query, Document document ) throws Exception {
	XPathFactory xpathFactory = XPathFactory.newInstance();
	XPath xpath = xpathFactory.newXPath();
	//InputSource inputSource = new InputSource(document);
	//System.out.println(document.getNodeValue());
	NodeList result = (NodeList) xpath.evaluate(query,document,XPathConstants.NODESET);
	System.out.println("XPath query: "+query);
	/*System.out.println(result.getLength());
	System.out.println("\nEnter choice \n1.Find rate of products higher than 4.5 \n2.Findname and price of products that contain the word sony \n"
			+ "3.Find names of all products whose name contains the word Sony and the price is between $1000 and $2000, inclusive.  ");
	*/
	
	
	Node n=result.item(0);
	//System.out.println("TRY MIN PRICE USING XPATH "+n.getTextContent());
	System.out.println("\nYour Result is:");
	for(int j=0;j<result.getLength();j++)
	{
		n=result.item(j);

		System.out.println("\n"+n.getTextContent());
		
		
		
	}
			
	
	
}
}
