package urouen.gil.project.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.util.FileCopyUtils;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;
import urouen.gil.project.model.STB;
import urouen.gil.project.utils.Utils;

import javax.xml.transform.Source;
import javax.xml.transform.stream.StreamSource;
import java.io.*;
import java.util.ArrayList;
import java.util.List;

@RestController 
public class STBController {

    @Autowired
    Service service;

	@RequestMapping(value = "Accueil", method = RequestMethod.GET)
	public @ResponseBody String accueil(){
		String str = "                  Accueil\n" +
                "Membres : Mohammed Zebouchi & Nabil Belkhous\n" +
                "Nombre de STB stocké :" + service.getSTBCount();
        return str;
	}


	@RequestMapping(value = "resume/{id}", method = RequestMethod.GET, produces = MediaType.APPLICATION_XML_VALUE)
	public @ResponseBody STB resumeId(@PathVariable String id){

		return service.getSTB(Integer.valueOf(id));
	}

	@RequestMapping(value = "depot", method = RequestMethod.POST)
	public @ResponseBody STB depot(@RequestParam(value = "file") MultipartFile fileXML){

        if (!fileXML.isEmpty()) {
            try {
                ClassLoader classLoader = getClass().getClassLoader();
                File fileXSD = new File(classLoader.getResource("STB.xsd").getFile());
                String xml = "";
                BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(fileXML.getInputStream()));
                String line = bufferedReader.readLine();
                while (line != null) {
                    xml += line + "\n";
                    line = bufferedReader.readLine();
                }
                if(Utils.validateXMLSchema(fileXSD, xml)){
                    return service.saveSTB(xml);
                }
            }catch (Exception e) {

            }
        }
        return null;
	}

	@RequestMapping(value = "depot/stream", method = RequestMethod.POST)
	public @ResponseBody STB depot(@RequestParam(value = "xmlStream") String xmlString){

		if (!xmlString.isEmpty()) {
			try {
				ClassLoader classLoader = getClass().getClassLoader();
				File fileXSD = new File(classLoader.getResource("STB.xsd").getFile());
                if(Utils.validateXMLSchema(fileXSD, xmlString)){
                    return service.saveSTB(xmlString);
                }
			}
			catch (Exception e) {

			}
		}
		return null;
	}


    @RequestMapping(value = "resume", method = RequestMethod.GET)
    public @ResponseBody List<String> resume(){

        List<String> resumeList = new ArrayList<String>();
        for(STB stb : service.getAllSTB()){
            String resume = stb.getId() + " - " + stb.getTitre() +" - " + stb.getVersion() + " - " + stb.getDate() + "\n";
            String descirption = stb.getDescription().substring(0, (stb.getDescription().length() > 200) ? 200 : stb.getDescription().length())
                    + ((stb.getDescription().length() < 200) ? "" : "...");
            resume += descirption;

            resumeList.add(resume);
        }
        return resumeList;
    }

}
