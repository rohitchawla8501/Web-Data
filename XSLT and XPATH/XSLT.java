package xslt;

import javax.xml.parsers.*;
import org.w3c.dom.*;
import org.xml.sax.InputSource;

import javax.xml.transform.*;
import javax.xml.transform.dom.*;
import javax.xml.transform.stream.*;
import java.io.*;
import java.net.URL;
import java.net.URLConnection;


class XSLT {
    public static void main ( String argv[] ) throws Exception {
	
   
    
		System.out.println("Enter a search key word");
		InputStreamReader ir=new InputStreamReader(System.in);
		BufferedReader br = new BufferedReader(ir);
		String str = null;
		String toconv="<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>";
		try {
			str = br.readLine();
		    str=str.replace(" ", "%20");
		} catch (IOException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
		System.out.println(str);
		
		
		try {
			URL u=new URL("http://sandbox.api.shopping.com/publisher/3.0/rest/GeneralSearch?apiKey=&visitorUserAgent&visitorIPAddress&trackingId=7000610&categoryId=72&keyword="+str+"&showAllDescendants=true&numItems=20");
			System.out.println("URL is " + u.toString());
	      
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
		File stylesheet = new File("search.xsl");
		File xmlfile  = new File("try2.xml");
		DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
		DocumentBuilder db = dbf.newDocumentBuilder();
		Document document = db.parse(xmlfile);
		StreamSource stylesource = new StreamSource(stylesheet);
		TransformerFactory tf = TransformerFactory.newInstance();
		Transformer transformer = tf.newTransformer(stylesource);
		DOMSource source = new DOMSource(xmldoc);
		StreamResult result = new StreamResult(System.out);
		transformer.transform(source,result);
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



}