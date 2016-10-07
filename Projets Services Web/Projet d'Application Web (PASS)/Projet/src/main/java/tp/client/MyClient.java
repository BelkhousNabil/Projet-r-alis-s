package tp.client;

import java.net.MalformedURLException;
import java.net.URL;
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

import tp.model.*;

public class MyClient {
    private Service service;
    private JAXBContext jc;

    private static final QName SERVICE_NAME = new QName("http://model.tp/", "CityManagerService");
    private static final QName PORT_NAME = new QName("http://model.tp/", "CityManagerPort");

    public static void main(String args[]) throws MalformedURLException {
        URL wsdlURL= new URL("http://m1gilapp-tp6anouarnabil.rhcloud.com/TP6/cityManager?wsdl");
        Service service = Service.create(wsdlURL,SERVICE_NAME);
        CityManagerService cityManager = service.getPort(PORT_NAME,CityManagerService.class);

        System.out.println("***** Affichage de l'ensemble des villes *****");
        System.out.println( cityManager.getCities());

        System.out.println("***** Suppression de toutes des villes *****");
        try {
            System.out.println(cityManager.removeAll());
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        System.out.println("***** Affichage de l'ensemble des villes *****");
        System.out.println( cityManager.getCities());

        //Ajout d'une cité
        System.out.println("***** Ajout de la ville Rouen à la position: Lat : 49.443889, Long: 1.103333 *****");
        try {
            cityManager.addCity(new City("Rouen", 49.443889, 1.103333, "FR"));
        } catch (ExistingCity existingCity) {
            System.err.println(existingCity.getMessage());
        }

        System.out.println("***** Ajout de la ville Mogadiscio à la position: Lat : 2.333333, Long: 48.85 *****");
        try {
            cityManager.addCity(new City("Mogadiscio", 2.333333, 48.85, "SO"));
        } catch (ExistingCity existingCity) {
            System.err.println(existingCity.getMessage());
        }

        System.out.println("***** Ajout de la ville Rouen à la position: Lat : 49.443889, Long: 1.103333 *****");
        try {
            cityManager.addCity(new City("Rouen", 49.443889, 1.103333, "FR"));
        } catch (ExistingCity existingCity) {
            System.err.println(existingCity.getMessage());
        }

        System.out.println("***** Ajout de la ville Bihorel à la position: Lat : 49.455278, Long: 1.116944 *****");
        try {
            cityManager.addCity(new City("Bihorel", 49.455278, 1.116944, "FR"));
        } catch (ExistingCity existingCity) {
            System.err.println(existingCity.getMessage());
        }

        System.out.println("***** Ajout de la ville Londres à la position: Lat : 51.504872, Long: -0.07857 *****");
        try {
            cityManager.addCity(new City("Londres", 51.504872, -0.07857, "UK"));
        } catch (ExistingCity existingCity) {
            System.err.println(existingCity.getMessage());
        }

        System.out.println("***** Ajout de la ville Paris à la position: Lat : 48.856578, Long: 2.351828 *****");
        try {
            cityManager.addCity(new City("Paris", 48.856578, 2.351828, "FR"));
        } catch (ExistingCity existingCity) {
            System.err.println(existingCity.getMessage());
        }

        System.out.println("***** Ajout de la ville Paris à la position: Lat : 43.2, Long: 80.38333 *****");
        try {
            cityManager.addCity(new City("Paris", 43.2, -80.38333, "CA"));
        } catch (ExistingCity existingCity) {
            System.err.println(existingCity.getMessage());
        }

        System.out.println("***** Affichage de l'ensemble des villes *****");
        System.out.println( cityManager.getCities());

        //ajout de villes
        System.out.println("***** Ajout de la ville Villers-Bocage à la position: Lat : 49.083333, Long: -0.65 *****");
        try {
            cityManager.addCity(new City("Villers-Bocage", 49.083333, -0.65, "FR"));
        } catch (ExistingCity existingCity) {
            existingCity.printStackTrace();
        }

        System.out.println("***** Ajout de la ville Villers-Bocage à la position: Lat : 50.021858, Long: 2.326126 *****");
        try {
            cityManager.addCity(new City("Villers-Bocage", 50.021858, 2.326126, "FR"));
        } catch (ExistingCity existingCity) {
            System.err.println(existingCity.getMessage());
        }


        System.out.println("***** Affichage de l'ensemble des villes *****");
        System.out.println( cityManager.getCities());

        System.out.println("***** Suupressiond de la ville Villers-Bocage *****");
        try {
            cityManager.searchExactPosition(new Position(49.083333,-0.65));
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        System.out.println("***** Affichage de l'ensemble des villes *****");
        System.out.println( cityManager.getCities());

        //suppression
        System.out.println("***** Suupressiond de la ville Londres *****");
        try {
            System.out.println(cityManager.removeCityPosition(new Position(51.504872,-0.07857)));
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        System.out.println("***** Suupressiond de la ville Londres *****");
        try {
            System.out.println(cityManager.removeCityPosition(new Position(51.504872,-0.07857)));
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        //recherche position exacte
        System.out.println("***** Recherche exacte de la ville qui est située à la position : Lat: 49.443889, Long: 1.103333 *****");
        try {
            System.out.println(cityManager.searchExactPosition(new Position(49.443889, 1.103333)));
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        System.out.println("***** Recherche exacte de la ville qui est située à la position : Lat: 49.083333, Long: -0.65 *****");
        try {
            System.out.println(cityManager.searchExactPosition(new Position(49.443889, 0.65)));
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        System.out.println("***** Recherche exacte de la ville qui est située à la position : Lat: 43.2, Long: -80.38 *****");
        try {
            System.out.println(cityManager.searchExactPosition(new Position(43.2, -80.38)));
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        //recherche position aproximative
        System.out.println("***** Recherche des villes situées a 10km de la potition: Lat: 48.85,Long: 2.34 *****");
        try {
            System.out.println(cityManager.searchNear(new Position(48.85,2.34)));
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        System.out.println("***** Recherche des villes situées a 10km de la potition: Lat: 42,Long: 64 *****");
        try {
            System.out.println(cityManager.searchNear(new Position(42,64)));
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        System.out.println("***** Recherche des villes situées a 10km de la potition: Lat: 49.45,Long: 1.11 *****");
        try {
            System.out.println(cityManager.searchNear(new Position(49.45,1.11)));
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        System.out.println("***** Afficher les ville de nom: Mogadiscio *****");
        try {
            System.out.println(cityManager.searchFor("Mogadiscio"));
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        System.out.println("***** Afficher les ville de nom: Paris *****");
        try {
            System.out.println(cityManager.searchFor("Paris"));
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        System.out.println("***** Afficher les ville de nom: Hyrule *****");
        try {
            System.out.println(cityManager.searchFor("Hyrule"));
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        System.out.println("***** Suppression de toutes des villes *****");
        try {
            System.out.println(cityManager.removeAll());
        } catch (CityNotFound e) {
            // TODO Auto-generated catch block
            System.err.println(e.getMessage());
        }

        System.out.println("***** Affichage de l'ensemble des villes *****");
        System.out.println( cityManager.getCities());

    }

}
