package tp.model;

import org.hibernate.Criteria;
import org.hibernate.Session;
import org.hibernate.Transaction;
import org.hibernate.criterion.Order;
import org.hibernate.criterion.Restrictions;
import org.omg.PortableServer.POA;
import tp.utils.HibernateUtil;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.LinkedList;
import java.util.List;

import javax.jws.WebService;
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
@WebService(endpointInterface = "tp.model.CityManagerService", serviceName = "CityManagerService")
public class CityManager implements CityManagerService{

	private Session session = null;
	
	public CityManager() {
        session = HibernateUtil.getSession();
	}

	public List<City> getCities() {
        Criteria criteria = session.createCriteria(City.class);
        List<City> cityList = criteria.list();
        return cityList;
	}


	public boolean addCity(City city) throws ExistingCity{
        try {
            if(searchExactPosition(city.getPosition()) != null){
                throw new ExistingCity("La ville exite déja");
            }
        } catch (CityNotFound cityNotFound) {

        }

        Transaction tx = session.beginTransaction();
        session.save(city);
        tx.commit();
        return true;
	}
	
	public boolean removeCity(City city) throws CityNotFound{
        City city1 = searchExactPosition(city.getPosition());

        if(city1 == null){
            throw new CityNotFound("La ville n'existe pas");
        }

        Transaction tx = session.beginTransaction();
        session.delete(city1);
        tx.commit();

		return true;
	}

    /**
     * searchFor permet de chercher une ville � partir son nom
     * @param cityName
     * @return cityList
     * @throws CityNotFound si la ville n'existe pas une exception sera lev�e
     */
	public List<City> searchFor(String cityName)  throws CityNotFound{

        Criteria criteria = session.createCriteria(City.class);
        criteria.add(Restrictions.eq("name", cityName));
        List<City> cityList = criteria.list();

		if(cityList.isEmpty()){
			throw new CityNotFound("Search cities : cities not  found");
		}
		return cityList;
	}

    /**
     * searchExactPosition permet de chercher une ville � partir de sa position exacte
     * @param position
     * @return city
     * @throws CityNotFound si la ville n'existe pas une exception sera lev�e
     */
	public City searchExactPosition(Position position) throws CityNotFound{
        Criteria criteriaP = session.createCriteria(Position.class);
        criteriaP.add(Restrictions.eq("latitude", position.getLatitude()));
        criteriaP.add(Restrictions.eq("longitude", position.getLongitude()));
        Position position1 = (Position) criteriaP.uniqueResult();
        if(position1 == null ){
            throw new CityNotFound("Search with exact Position : City not found");
        }

        Criteria criteria = session.createCriteria(City.class);
        criteria.add(Restrictions.eq("position", position1));
        City city = (City) criteria.uniqueResult();

        if(city == null){
            throw new CityNotFound("Search with exact Position : City not found");
        }
        else{
            return  city;
        }

	}

	/**
	 * TODO: searchNear : une fonction qui retourne la liste des villes � dix klom�tres d'une position
	 */

	/**
	 * Distance entre 2 points GPS
	 *
	 * distanceVolOiseau nou permet de calculuer la distance mesur�e le long d'un arc de grand cercle entre deux points dont on connait les coordonn�es {lat1,lon1} et {lat2,lon2} est donn�e par :
	 * La formule, math�matiquement �quivalente
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
		 * Conversion des entr�es en � vers le radian
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
     * searchNear permet de donner la liste des villle qui se � moins de 10 KM de la position donn�e.
     * @param position
     * @return
     * @throws CityNotFound si la ville n'existe pas une exception sera lev�e
     */
	public List<City> searchNear(Position position) throws CityNotFound{
		List<City> NearCities = getCities();

        for(City city1:NearCities){
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

	@Override
	public boolean removeAll() throws CityNotFound {

        Criteria criteria = session.createCriteria(City.class);
        List<City> cityList = criteria.list();
        Transaction tx = session.beginTransaction();

        if(getCities().isEmpty()){
            throw new CityNotFound("La liste est vide");
        }

        for(City city : cityList){
            session.delete(city);
        }
        tx.commit();

		return true;
	}

	@Override
	public boolean removeCityPosition(Position position) throws CityNotFound {
		City city = searchExactPosition(position);

        if(city == null){
            throw new CityNotFound("La ville n'existe pas");
        }

        Transaction tx = session.beginTransaction();
        session.delete(city);
        tx.commit();

		return false;
	}

}

