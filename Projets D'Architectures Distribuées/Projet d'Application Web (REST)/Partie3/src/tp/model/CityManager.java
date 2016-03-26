package tp.model;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.LinkedList;
import java.util.List;

import javax.xml.bind.annotation.XmlRootElement;

/**
 * This class represent a city manager, it can  
 * <ul>
 * 	<li>add a city</li>
 * 	<li>remove a city</li>
 * 	<li>return the list of cities</li>	
 * 	<li>search a city with a given name</li>
 *  <li>search a city at a position</li>
 * 	<li>return the list of cities near 10km of the given position</li>
 * </ul>
 *
 */
@XmlRootElement
public class CityManager {

	private List<City> cities;
	
	public CityManager() {
		this.cities = new LinkedList<City>();
	}

	public List<City> getCities() {
		return cities;
	}

	public void setCities(List<City> cities) {
		this.cities = cities;
	}
	
	public void addAll(List<City> cities) {
		this.cities.addAll(cities);
	}
	
	public boolean addCity(City city){
		return cities.add(city);
	}
	
	public boolean removeCity(City city){
		return cities.remove(city);
	}
	
	public boolean removeCityAll(List<City> citiesTmp){
		return cities.removeAll(citiesTmp);
	}

    /**
     * searchFor permet de chercher une ville à  partir son nom
     * @param cityName
     * @return cityList
     * @throws CityNotFound si la ville n'existe pas une exception sera levée
     */
	public List<City> searchFor(String cityName)  throws CityNotFound{

		// TODO: Ã  complÃ©ter
		List<City> cityList = new ArrayList<City>();
		for(City city : cities){
			if(city.getName().equals(cityName)){
				cityList.add(city);
			}
		}

		if(cityList.isEmpty()){
			throw new CityNotFound("Search cities : cities not  found");
		}
		return cityList;
	}

    /**
     * searchExactPosition permet de chercher une ville à partir de sa position exacte
     * @param position
     * @return city
     * @throws CityNotFound si la ville n'existe pas une exception sera levée
     */
	public City searchExactPosition(Position position) throws CityNotFound{
		for(City city:cities){
			if (position.equals(city.getPosition())){
				return city;
			}
		}
		throw new CityNotFound("Search with exact Position : City not found");
	}

	/**
	 * TODO: searchNear : une fonction qui retourne la liste des villes à  dix klomètres d'une position
	 */

	/**
	 * Distance entre 2 points GPS
	 *
	 * distanceVolOiseau nou permet de calculuer la distance mesurée le long d'un arc de grand cercle entre deux points dont on connait les coordonnées {lat1,lon1} et {lat2,lon2} est donnée par :
	 * La formule, mathématiquement équivalente
	 * d=2*asin(sqrt((sin((lat1-lat2)/2))^2 + cos(lat1)*cos(lat2)*(sin((lon1- lon2)/2))^2))
	 *
	 * @param lat1
	 * @param lon1
	 * @param lat2
	 * @param lon2
	 * @return le calcule de la distance
	 */
	public double distanceVolOiseau(double lat1, double lon1, double lat2, double lon2) {
		// d=2*asin(sqrt((sin((lat1-lat2)/2))^2 + cos(lat1)*cos(lat2)*(sin((lon1- lon2)/2))^2))
		return 2 *Math.asin(Math.sqrt(Math.pow((Math.sin((lat1 - lat2) / 2)),2)+Math.cos(lat1) * Math.cos(lat2) * (Math.pow(Math.sin(((lon1-lon2)/2)),2))							));
	}

	/**
     * disatance permet de calculer la distance entre 2 positions en KM
	 * @param p1
	 * @param p2
	 * @return distanceVolOiseau * 6366
	 */
	public double distance(Position p1, Position p2){

		/**
		 * Conversion des entrées en ° vers le radian
		 */
		p1.setLatitude(Math.toRadians(p1.getLatitude()));
		p1.setLongitude(Math.toRadians(p1.getLongitude()));

		p2.setLatitude(Math.toRadians(p2.getLatitude()));
		p2.setLongitude(Math.toRadians(p2.getLongitude()));

		double lat1 = p1.getLatitude(); double lon1 = p1.getLongitude();
		double lat2 = p2.getLatitude(); double lon2 = p2.getLongitude();

		double distance = distanceVolOiseau(lat1, lon1, lat2, lon2);

		return distance * 6366;
	}

    /**
     * searchNear permet de donner la liste des villle qui se à  moins de 10 KM de la position donnée.
     * @param position
     * @return
     * @throws CityNotFound si la ville n'existe pas une exception sera levée
     */
	public List<City> searchNear(Position position) throws CityNotFound{
		List<City> NearCities = new LinkedList<City>();

        for(City city1:cities){
            if (distance(city1.getPosition(),position) < 10 ){
                if(!NearCities.contains(city1)){
                    NearCities.add(city1);
                }
            }
        }

		if(NearCities.isEmpty()){
			throw new CityNotFound("Search for near : no near city found");
		}

		return  NearCities ;
	}

}

