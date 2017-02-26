package com.company;

import java.util.Observable;
import java.util.Observer;

/**
 * Created by BELKHOUS on 08/02/2016.
 */
public class ObserverHelp implements Observer {
    @Override
    public void update(Observable o, Object arg) {
        if(menu.type=="about"){
            System.out.println("UN NOUVEAU CHANGEMENT DANS HELP");
            System.out.println("*******************************");
        }
    }
}

