package tp.model;

import java.util.List;

import javax.jws.WebService;

@WebService
public interface CityManagerService {
	boolean addCity (City city);
	boolean removeCity(City city) throws CityNotFound;
	boolean removeCityPosition(Position position) throws CityNotFound;
	List<City> getCities();
	City searchExactPosition(Position position) throws CityNotFound;
	List<City> searchNear(Position position) throws CityNotFound;
	List<City> searchFor(String cityName)  throws CityNotFound;
	boolean removeAll() throws CityNotFound;
	
}
