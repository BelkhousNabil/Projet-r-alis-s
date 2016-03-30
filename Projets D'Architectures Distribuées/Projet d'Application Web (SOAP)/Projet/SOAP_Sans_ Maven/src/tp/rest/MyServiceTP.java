package tp.rest;
import javax.xml.ws.Endpoint;

import tp.model.City;
import tp.model.CityManager;

public class MyServiceTP{
	
	public MyServiceTP(){
		CityManager cityManager = new CityManager();
		cityManager.addCity(new City("Paris", 48.856578, 2.351828, "FR"));
		cityManager.addCity(new City("Villers-Bocage", 49.083333, -0.65, "FR"));
		cityManager.addCity(new City("Londres", 51.504872, -0.07857, "UK"));
		cityManager.addCity(new City("Rouen", 49.443889, 1.103333, "FR"));
		
		
		Endpoint.publish("http://127.0.0.1:8084/cityManager", cityManager);
	}
 
	public static void main(String args[]) throws InterruptedException {
		new MyServiceTP();
		Thread.sleep(15*60*1000);
		System.exit(0);
	}

    
}
