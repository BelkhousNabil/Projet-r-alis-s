package tp.model;

import javax.xml.bind.annotation.XmlRootElement;

@XmlRootElement
public class CityNotFound extends Exception {

    private  String message;

    /**
     * Construteur par defaut
     */
    public CityNotFound(){
        super();
        this.message = "";
    }

    /**
     * CityNotFound permet de renvoyer l'exeption avec le bon message
     * @param message
     */
    public CityNotFound(String message){
        super(message);
        this.message = message;
    }

    /**
     * getMessage Getter de message
     */
    public String getMessage() {
        return message;
    }

    /**
     * setMessage setter de message
     * @param message
     */
    public void setMessage(String message) {
        this.message = message;
    }
}
