package tp.model;

import javax.persistence.*;
import javax.xml.bind.annotation.XmlRootElement;
import java.io.Serializable;

/**
 * This class represent a city with its  
 * <ul>
 * 	<li>name</li>
 * 	<li>latitude</li>
 * 	<li>longitude</li>
 * 	<li>country</li>
 * </ul>
 *
 */
@XmlRootElement
@Entity
public class City  implements Serializable {

    @Id
    @GeneratedValue
    @Column(nullable = false)
    private int id;
    private String name;
	private String country;
    @OneToOne(fetch = FetchType.LAZY, cascade = CascadeType.ALL)
    private Position position;



    /**
     * Creates a city with its name, its latitude, its longitude and its country
     * @param name the name of the city
     * @param latitude the latitude of the city in WGS84
     * @param longitude the longitude of the city in WGS84
     * @param country the country of the city
     */
    public City(String name, double latitude, double longitude, String country) {
        this.name = name;
        this.position = new Position(latitude,longitude);
        this.country = country;
    }

    public City() {
	}



    public Position getPosition() {
		return position;
	}
	public void setPosition(Position position) {
		this.position = position;
	}
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public String getCountry() {
		return country;
	}
	public void setCountry(String country) {
		this.country = country;
	}
	
	public String toString(){
		final StringBuffer buffer = new StringBuffer();
		buffer.append(name).append(" in ").append(country).append(" at ").append(position);
		return buffer.toString();
	}

	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		City other = (City) obj;
		if (country == null) {
			if (other.country != null)
				return false;
		} else if (!country.equals(other.country))
			return false;
		if (position == null) {
			if (other.position != null)
				return false;
		} else if (!position.equals(other.position))
			return false;
		if (name == null) {
			if (other.name != null)
				return false;
		} else if (!name.equals(other.name))
			return false;
		return true;
	}	
		
}
