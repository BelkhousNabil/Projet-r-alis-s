package tp.rest;
import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.xml.bind.JAXBContext;
import javax.xml.bind.JAXBException;
import javax.xml.bind.Unmarshaller;
import javax.xml.bind.util.JAXBSource;
import javax.xml.transform.Source;
import javax.xml.ws.Endpoint;
import javax.xml.ws.Provider;
import javax.xml.ws.Service;
import javax.xml.ws.ServiceMode;
import javax.xml.ws.WebServiceContext;
import javax.xml.ws.WebServiceException;
import javax.xml.ws.WebServiceProvider;
import javax.xml.ws.handler.MessageContext;
import javax.xml.ws.http.HTTPBinding;

import tp.model.City;
import tp.model.CityManager;
import tp.model.CityNotFound;
import tp.model.Position;

@WebServiceProvider
@ServiceMode(value=Service.Mode.MESSAGE)
public class MyServiceTP implements Provider<Source> {
	
	/**
	 * Gérere les villes
	 */
	private CityManager cityManager = new CityManager();
	
	private JAXBContext jc;
	
	@javax.annotation.Resource(type=Object.class)
	protected WebServiceContext wsContext;
	
	public MyServiceTP(){
		try {
            jc = JAXBContext.newInstance(CityManager.class,City.class,Position.class, CityNotFound.class);
            
        } catch(JAXBException je) {
            System.out.println("Exception " + je);
            throw new WebServiceException("Cannot create JAXBContext", je);
        }
        cityManager.addCity(new City("Rouen",49.437994,1.132965,"FR"));
        cityManager.addCity(new City("Neuor",12,42,"RF"));
	}
	 
    public Source invoke(Source source)  {
    	
        try{
            MessageContext mc = wsContext.getMessageContext();
            String path = (String)mc.get(MessageContext.QUERY_STRING);
            String method = (String)mc.get(MessageContext.HTTP_REQUEST_METHOD);
            System.out.println("Got HTTP "+method+" request for "+path);
		    if (method.equals("GET"))
	                return get(mc);
			if (method.equals("POST"))
				    return post(source, mc);
           	if (method.equals("PUT"))
					return put(source, mc);
           	if (method.equals("DELETE"))
					return delete(source, mc);
			throw new WebServiceException("Unsupported method:" +method);
        } catch(JAXBException je) {
            throw new WebServiceException(je);
        }
	}

    /**
     * put permet d'ajouter une ville dans la liste de citymanager
     * @param source
     * @param mc
     * @return la liste citymanager
     * @throws JAXBException
     */
	private Source put(Source source, MessageContext mc) throws JAXBException {
		// TODO Ã  compléter
		// * ajouter une ville passée en paramètre au citymanager

		Unmarshaller u = jc.createUnmarshaller();
		City city=(City)u.unmarshal(source);

		cityManager.addCity(city);
		System.out.println("Ajout de : "+city.toString());
		return new JAXBSource(jc, city);
	}

    /**
     * delete permet de supprimer une ville de citymanager
     * @param source
     * @param mc
     * @return la liste citymanager
     * @throws JAXBException
     */
	private Source delete(Source source, MessageContext mc) throws JAXBException {
		
		// TODO Ã  complÃ©ter 
		// * effacer toute la liste de ville
		// * effacer la ville passÃ©e en paramÃ¨tre
		String query = (String) mc.get(MessageContext.QUERY_STRING);
		Map<String, List<String>>  mapParams = getQueryParams(query);
        Object message = cityManager;
		if(mapParams.containsKey("ville")){
			List<String> listVilleParams = mapParams.get("ville");
			
			for(String ville : listVilleParams) {
                if(listVilleParams.contains("all")){
                    cityManager.removeCityAll(cityManager.getCities());
                }

                else{
                    List<City> cities = null;


                    try {
                        cities = cityManager.searchFor(ville);
                        cityManager.removeCityAll(cities);
                    } catch (CityNotFound cityNotFound) {
                        message = cityNotFound;
                    }
                }
            }
		}
        else if(mapParams.containsKey("lat") &&  mapParams.containsKey("log")){
            String lat = mapParams.get("lat").get(0);
            String log = mapParams.get("log").get(0);

            if(!lat.isEmpty() && !log.isEmpty()){
                Position position = new Position(Double.parseDouble(lat), Double.parseDouble(log));
                try {
                    City city = cityManager.searchExactPosition(position);
                    cityManager.removeCity(city);
                } catch (CityNotFound cityNotFound) {
                    message = cityNotFound;
                }
            }

        }
		
		return new JAXBSource(jc, message);
	}

    /**
     * post permet de récuperer une ville (précise ou proche) dans citymanager
     * @param source
     * @param mc
     * @return la liste citymanager
     * @throws JAXBException
     */
	private Source post(Source source, MessageContext mc) throws JAXBException {
		// * rechercher une ville Ã  partir de sa position
		Unmarshaller u = jc.createUnmarshaller();
		Position position=(Position)u.unmarshal(source);
		Object message;


		// TODO Ã  complÃ©ter 
		// * rechercher les villes proches de cette position si l'url de post contient le mot clÃ© "near"

        String path = (String) mc.get(MessageContext.QUERY_STRING);
        if (path != null && path.contains("near")) {
            List<City> citiesNears = null;
            try {
                citiesNears = cityManager.searchNear(position);
                CityManager cityManagerTMP = new CityManager();
                cityManagerTMP.addAll(citiesNears);
                message =  cityManagerTMP;
            } catch (CityNotFound cnf) {
                message = cnf;
            }
		} else {
			System.out.println("Affichage des villes Ã  : "+position.toString());
			try {
				message = cityManager.searchExactPosition(position);
			} catch (CityNotFound cnf) {
				// TODO: retourner correctement l'exception
				message = cnf;
			}
		}

		return new JAXBSource(jc, message);
	}

    /**
     * get permet de récuperer le nom de la ou les villes dont le nom est passée en parametre dans citymanager
     * @param mc
     * @return la liste citymanager
     * @throws JAXBException
     */
	private Source get(MessageContext mc) throws JAXBException {
		// TODO Ã  complÃ©ter 
		// * retourner seulement la ville dont le nom est contenu dans l'url d'appel
		// * retourner tous les villes seulement si le chemin d'accÃ¨s est "all"
		String query = (String) mc.get(MessageContext.QUERY_STRING);
        Object message = cityManager;
        if(query != null){
            Map<String, List<String>>  mapParams = getQueryParams(query);

            if(mapParams.containsKey("ville")){
                    List<String> listVilleParams = mapParams.get("ville");
                    if(!listVilleParams.contains("all")){
                        CityManager cityManagerTMP = new CityManager();
                        for(String ville : listVilleParams){
                            try {
                                cityManagerTMP.addAll(cityManager.searchFor(ville));
                                message  = cityManagerTMP;
                            } catch (CityNotFound cityNotFound) {
                                message  = cityNotFound;
                            }
                        }
                    }
            }
        }
		return new JAXBSource(jc, message);
	}

	public static void main(String args[]) {
	      Endpoint e = Endpoint.create( HTTPBinding.HTTP_BINDING,
	                                     new MyServiceTP());
	      e.publish("http://127.0.0.1:8084/");
	       // pour arrÃªter : e.stop();
	 }

    /**
     * getQueryParams permet donner les parametre de l'URL
     * @param query
     * @return la liste params
     */
	public static Map<String, List<String>> getQueryParams(String query) {
	    try {
	    	Map<String, List<String>> params = new HashMap<String, List<String>>();
	      	for (String param : query.split("&")) {
                String[] pair = param.split("=");
                String key = URLDecoder.decode(pair[0], "UTF-8");
                String value = "";
                if (pair.length > 1) {
                    value = URLDecoder.decode(pair[1], "UTF-8");
                }

                List<String> values = params.get(key);
                if (values == null) {
                    values = new ArrayList<String>();
                    params.put(key, values);
                }
                values.add(value);
            }
	        return params;
	    } catch (UnsupportedEncodingException ex) {
	        throw new AssertionError(ex);
	    }
	}
}
