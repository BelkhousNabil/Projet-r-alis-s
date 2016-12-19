package SAXValidation;

import java.io.File;
import java.io.IOException;

import javax.xml.XMLConstants;
import javax.xml.transform.stream.StreamSource;
import javax.xml.validation.Schema;
import javax.xml.validation.SchemaFactory;
import javax.xml.validation.Validator;

import org.xml.sax.SAXException;

public class XSDValidator {
   public static void main(String[] args) {
  
	   String xmlPath = "C:\\Users\\BELKHOUS\\Desktop\\TP-2015-2016-S2\\Workspace(JEE)\\XMLValidation\\src\\SAXValidation\\STB.xml";
	   String xsdPath = "C:\\Users\\BELKHOUS\\Desktop\\TP-2015-2016-S2\\Workspace(JEE)\\XMLValidation\\src\\SAXValidation\\STB.xsd";
	   boolean isValid = validateXMLSchema(xsdPath,xmlPath);
	   if(isValid){
		   System.out.println("STB.xlm is valid against STB.xsd");
	   }
	   else {
		   		System.out.println("STB.xlm is not valid against STB.xsd");
	   }
   }
   
   public static boolean validateXMLSchema(String xsdPath, String xmlPath){
      try {
         SchemaFactory factory = 
            SchemaFactory.newInstance(XMLConstants.W3C_XML_SCHEMA_NS_URI);
         Schema schema = factory.newSchema(new File(xsdPath));
            Validator validator = schema.newValidator();
            validator.validate(new StreamSource(new File(xmlPath)));
      } catch (IOException e){    
         System.out.println("Exception: "+e.getMessage());
         return false;
      }catch(SAXException e1){
         System.out.println("SAX Exception: "+e1.getMessage());
         return false;
      }
      return true;
   }
}