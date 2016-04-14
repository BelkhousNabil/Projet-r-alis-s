/*
 * Copyright 2016 Guillaume Leroy, Axelle Boucher, Mohammed Zebouchi, Safae Mahmdi, 
 * Najwa Jmaa & Antoine Gilbert

 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at

 *     http://www.apache.org/licenses/LICENSE-2.0

 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
package tp.model;

import javax.xml.bind.annotation.XmlRootElement;

/**
 * Class That.
 *
 * @author Zebouchi Mohammed <zebouchi.mohammed@gmail.com>, Safae M'hamdi<mhamdi.safae@gmail.com>
 */
@XmlRootElement
public class ExistingCity extends Exception  {

    private  String message;

    /**
     * Construteur par defaut
     */
    public ExistingCity(){
        super();
        this.message = "";
    }

    /**
     * CityNotFound permet de renvoyer l'exeption avec le bon message
     * @param message
     */
    public ExistingCity(String message){
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
