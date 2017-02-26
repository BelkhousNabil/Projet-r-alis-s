package com.company;

import java.util.Observable;
import java.util.Observer;

/**
 * Created by BELKHOUS on 08/02/2016.
 */
public class ObserverEntity implements Observer {
    @Override
    public void update(Observable o, Object arg) {
        if(menu.type=="entity"){
            System.out.println("UN NOUVEAU CHANGEMENT DANS ENTITY");
            System.out.println("*********************************");
        }
    }
}

