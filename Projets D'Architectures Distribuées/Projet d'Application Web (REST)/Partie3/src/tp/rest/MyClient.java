package tp.rest;

import java.util.Map;

import javax.xml.bind.JAXBContext;
import javax.xml.bind.JAXBException;
import javax.xml.bind.util.JAXBSource;
import javax.xml.namespace.QName;
import javax.xml.transform.Source;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.stream.StreamResult;
import javax.xml.ws.Dispatch;
import javax.xml.ws.Service;
import javax.xml.ws.handler.MessageContext;
import javax.xml.ws.http.HTTPBinding;

import tp.model.City;
import tp.model.CityManager;
import tp.model.CityNotFound;
import tp.model.Position;

public class MyClient {
	private Service service;
	private JAXBContext jc;

	private static final QName qname = new QName("", "");
	private static final String url = "http://127.0.0.1:8084";

	public MyClient() {
		try {
			jc = JAXBContext.newInstance(CityManager.class, City.class,
					Position.class, CityNotFound.class);
		} catch (JAXBException je) {
			System.out.println("Cannot create JAXBContext " + je);
		}
	}

    /**
     * searchForCity nous permet de chercher une cité à partir de sa position
     * @param position
     * @throws JAXBException
     */
	public void searchForCity(Position position) throws JAXBException {
		service = Service.create(qname);
		service.addPort(qname, HTTPBinding.HTTP_BINDING, url);
		Dispatch<Source> dispatcher = service.createDispatch(qname,
				Source.class, Service.Mode.MESSAGE);
		Map<String, Object> requestContext = dispatcher.getRequestContext();
		requestContext.put(MessageContext.HTTP_REQUEST_METHOD, "POST");
		Source result = dispatcher.invoke(new JAXBSource(jc, position));
		printSource(result);
	}

    /**
     * searchForCityNear nous permet de chercher les ville qui sont près de la position donnée.
     * @param position
     * @throws JAXBException
     */
    public void searchForCityNear(Position position) throws JAXBException {
        service = Service.create(qname);
        service.addPort(qname, HTTPBinding.HTTP_BINDING, url);
        Dispatch<Source> dispatcher = service.createDispatch(qname,
                Source.class, Service.Mode.MESSAGE);
        Map<String, Object> requestContext = dispatcher.getRequestContext();
        requestContext.put(MessageContext.HTTP_REQUEST_METHOD, "POST");
        requestContext.put(MessageContext.QUERY_STRING, "near");
        Source result = dispatcher.invoke(new JAXBSource(jc, position));
        printSource(result);
    }

    /**
     * getSimpleRequest fait une requête simple avec un parametre et un mode
     * @param Params
     * @param mode
     * @throws JAXBException
     */
	public void getSimpleRequest(String Params , String mode) throws JAXBException {
		service = Service.create(qname);
		service.addPort(qname, HTTPBinding.HTTP_BINDING, url);
		Dispatch<Source> dispatcher = service.createDispatch(qname,
				Source.class, Service.Mode.MESSAGE);
		Map<String, Object> requestContext = dispatcher.getRequestContext();
		requestContext.put(MessageContext.HTTP_REQUEST_METHOD, mode);
		requestContext.put(MessageContext.QUERY_STRING, Params);
		Source result = dispatcher.invoke(new JAXBSource(jc,new Position()));
        printSource(result);
	}

    /**
     * DeleteCityPosition permet de supprimer une cité à partir de son adresse
     * @param p
     * @throws JAXBException
     */
    public void DeleteCityPosition(Position p) throws JAXBException {
        String params = "lat=" + p.getLatitude() + "&log=" + p.getLongitude();
        getSimpleRequest(params, "DELETE");
    }

    /**
     * addCity nous permet d'ajouter une nouvelle ville
     * @param city
     * @throws JAXBException
     */
    public void addCity(City city) throws JAXBException {
        service = Service.create(qname);
        service.addPort(qname, HTTPBinding.HTTP_BINDING, url);
        Dispatch<Source> dispatcher = service.createDispatch(qname,
                Source.class, Service.Mode.MESSAGE);
        Map<String, Object> requestContext = dispatcher.getRequestContext();
        requestContext.put(MessageContext.HTTP_REQUEST_METHOD, "PUT");
        Source result = dispatcher.invoke(new JAXBSource(jc, city));
        printSource(result);
    }

	public void printSource(Source s) {
		try {
			System.out.println("============================= Response Received =========================================");
			TransformerFactory factory = TransformerFactory.newInstance();
			Transformer transformer = factory.newTransformer();
			transformer.transform(s, new StreamResult(System.out));
			System.out.println("\n======================================================================");
		} catch (Exception e) {
			System.out.println(e);
		}
	}

	public static void main(String args[]) throws Exception {
		MyClient client = new MyClient();

		System.out.println("***** Affichage de l'ensemble des villes *****");
        client.getSimpleRequest("ville=all","GET");

		System.out.println("***** Suppression de toutes des villes *****");
        client.getSimpleRequest("ville=all","DELETE");

		System.out.println("***** Affichage de l'ensemble des villes *****");
        client.getSimpleRequest("ville=all","GET");

        //Ajout d'une cité
		System.out.println("***** Ajout de la ville Rouen à la position: Lat : 49.443889, Long: 1.103333 *****");
        client.addCity(new City("Rouen", 49.443889, 1.103333, "FR"));

		System.out.println("***** Ajout de la ville Mogadiscio à la position: Lat : 2.333333, Long: 48.85 *****");
        client.addCity(new City("Mogadiscio", 2.333333, 48.85, "SO"));

		System.out.println("***** Ajout de la ville Rouen à la position: Lat : 49.443889, Long: 1.103333 *****");
        client.addCity(new City("Rouen", 49.443889, 1.103333, "FR"));

		System.out.println("***** Ajout de la ville Bihorel à la position: Lat : 49.455278, Long: 1.116944 *****");
        client.addCity(new City("Bihorel", 49.455278, 1.116944, "FR"));

		System.out.println("***** Ajout de la ville Londres à la position: Lat : 51.504872, Long: -0.07857 *****");
        client.addCity(new City("Londres", 51.504872, -0.07857, "UK"));

		System.out.println("***** Ajout de la ville Paris à la position: Lat : 48.856578, Long: 2.351828 *****");
        client.addCity(new City("Paris", 48.856578, 2.351828, "FR"));

		System.out.println("***** Ajout de la ville Paris à la position: Lat : 43.2, Long: 80.38333 *****");
        client.addCity(new City("Paris", 43.2, -80.38333, "CA"));

		System.out.println("***** Affichage de l'ensemble des villes *****");
        client.getSimpleRequest("ville=all","GET");

        //ajout de villes
		System.out.println("***** Ajout de la ville Villers-Bocage à la position: Lat : 49.083333, Long: -0.65 *****");
        client.addCity(new City("Villers-Bocage", 49.083333, -0.65, "FR"));

		System.out.println("***** Ajout de la ville Villers-Bocage à la position: Lat : 50.021858, Long: 2.326126 *****");
        client.addCity(new City("Villers-Bocage", 50.021858, 2.326126, "FR"));


		System.out.println("***** Affichage de l'ensemble des villes *****");
        client.getSimpleRequest("ville=all","GET");

		System.out.println("***** Suupressiond de la ville Villers-Bocage *****");
        client.getSimpleRequest("lat=49.083333&log=-0.65","DELETE");

		System.out.println("***** Affichage de l'ensemble des villes *****");
        client.getSimpleRequest("ville=all","GET");

        //suppression
		System.out.println("***** Suupressiond de la ville Londres *****");
        client.getSimpleRequest("lat=51.504872&log=-0.07857","DELETE");

		System.out.println("***** Suupressiond de la ville Londres *****");
        client.getSimpleRequest("lat=51.504872&log=-0.07857","DELETE");

        //recherche position exacte
		System.out.println("***** Recherche exacte de la ville qui est située à la position : Lat: 49.443889, Long: 1.103333 *****");
        client.searchForCity(new Position(49.443889, 1.103333));

		System.out.println("***** Recherche exacte de la ville qui est située à la position : Lat: 49.083333, Long: -0.65 *****");
        client.searchForCity(new Position(49.083333, -0.65));

		System.out.println("***** Recherche exacte de la ville qui est située à la position : Lat: 43.2, Long: -80.38 *****");
        client.searchForCity(new Position(43.2, -80.38));

        //recherche position aproximative
		System.out.println("***** Recherche des villes situées a 10km de la potition: Lat: 48.85,Long: 2.34 *****");
        client.searchForCityNear(new Position(48.85,2.34));

		System.out.println("***** Recherche des villes situées a 10km de la potition: Lat: 42,Long: 64 *****");
        client.searchForCityNear(new Position(42,64));

		System.out.println("***** Recherche des villes situées a 10km de la potition: Lat: 49.45,Long: 1.11 *****");
        client.searchForCityNear(new Position(49.45,1.11));

		System.out.println("***** Afficher les ville de nom: Mogadiscio *****");
        client.getSimpleRequest("ville=Mogadiscio","GET");

		System.out.println("***** Afficher les ville de nom: Paris *****");
        client.getSimpleRequest("ville=Paris","GET");

		System.out.println("***** Afficher les ville de nom: Hyrule *****");
        client.getSimpleRequest("ville=Hyrule","GET");

		System.out.println("***** Suppression de toutes des villes *****");
		client.getSimpleRequest("ville=all","DELETE");

		System.out.println("***** Affichage de l'ensemble des villes *****");
		client.getSimpleRequest("ville=all","GET");

	}
}
