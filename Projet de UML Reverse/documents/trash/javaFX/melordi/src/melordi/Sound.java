/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package melordi;

import javafx.beans.value.ChangeListener;
import javafx.beans.value.ObservableValue;
import javafx.geometry.Orientation;
import javafx.scene.Parent;
import javafx.scene.control.ProgressIndicator;
import javafx.scene.control.Slider;

/**
 *
 * @author anto
 */
public class Sound extends Parent {
    
    private final Slider slider;
    private final Keyboard keyboard; 
    
    public Sound(Keyboard keyboard){
        
        this.keyboard = keyboard;
        
        slider = new Slider(0, 127, 60);
        slider.setOrientation(Orientation.VERTICAL);
        slider.setTranslateY(35);
        
        slider.valueProperty().addListener(new ChangeListener(){
            @Override 
            public void changed(ObservableValue o, Object oldVal, Object newVal){
                keyboard.requestFocus();
            }
        });
        
        ProgressIndicator indicateur = new ProgressIndicator(0.0);
        indicateur.progressProperty().bind(slider.valueProperty().divide(127.0));
        
        this.getChildren().add(slider);
        this.getChildren().add(indicateur);
        this.setTranslateY(260);
        this.setTranslateX(60);
    }
    
// REQUETES
    
    public Slider getSlider() {
        return slider;
    }
}
