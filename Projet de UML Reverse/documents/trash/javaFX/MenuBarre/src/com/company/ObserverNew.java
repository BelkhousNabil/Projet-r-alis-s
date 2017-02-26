package com.company;

import java.util.Observable;
import java.util.Observer;

/**
 * Created by BELKHOUS on 08/02/2016.
 */
public class ObserverNew implements Observer {
    @Override
    public void update(Observable o, Object arg) {
        if(menu.type=="new"){
            System.out.println("UN NOUVEAU CHANGEMENT DANS NEW");
            System.out.println("******************************");
        }
    }
}
