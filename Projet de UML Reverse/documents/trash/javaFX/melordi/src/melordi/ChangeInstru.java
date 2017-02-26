/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package melordi;

import javafx.beans.value.ChangeListener;
import javafx.beans.value.ObservableValue;
import javafx.scene.Parent;
import javafx.scene.control.RadioButton;
import javafx.scene.control.Toggle;
import javafx.scene.control.ToggleGroup;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.GridPane;

/**
 *
 * @author anto
 */
public class ChangeInstru extends Parent {
    
    private final RadioButton rb_piano;
    private final RadioButton rb_guitar;
    private final RadioButton rb_organ;
    
    public ChangeInstru(Instru instru){
        GridPane gridpane = new GridPane();
        
        ImageView piano = new ImageView(new Image(ChangeInstru.class.getResourceAsStream("img/piano.png")));
        piano.setFitHeight(50);
        piano.setPreserveRatio(true);
        ImageView guitare = new ImageView(new Image(ChangeInstru.class.getResourceAsStream("img/guitar.png")));
        guitare.setFitHeight(50);
        guitare.setPreserveRatio(true);
        ImageView orgue = new ImageView(new Image(ChangeInstru.class.getResourceAsStream("img/organ.png")));
        orgue.setFitHeight(50);
        orgue.setPreserveRatio(true);
        
        ToggleGroup groupe = new ToggleGroup();
        rb_piano = new RadioButton();
        rb_guitar = new RadioButton();
        rb_organ = new RadioButton();
        rb_piano.setToggleGroup(groupe);
        rb_guitar.setToggleGroup(groupe);
        rb_organ.setToggleGroup(groupe);
        rb_piano.setFocusTraversable(false);
        rb_guitar.setFocusTraversable(false);
        rb_organ.setFocusTraversable(false);
        rb_piano.setSelected(true);
        
        groupe.selectedToggleProperty().addListener(new ChangeListener<Toggle>(){
            @Override
            public void changed(ObservableValue<? extends Toggle> observable, Toggle oldValue, Toggle newValue) {
                if(newValue.equals(rb_piano)) {
                    instru.set_instrument(0);
                }
                else if(newValue.equals(rb_guitar)) {
                    instru.set_instrument(26);
                } else {
                    instru.set_instrument(16);//numéro MIDI de l'orgue = 16
                }
            }
        });
        
        gridpane.add(piano, 1, 0);
        gridpane.add(guitare, 1, 1);
        gridpane.add(orgue, 1, 2);
        gridpane.setVgap(15);
        
        gridpane.add(rb_piano, 0, 0);
        gridpane.add(rb_guitar, 0, 1);
        gridpane.add(rb_organ, 0, 2);
        gridpane.setHgap(20);
        
        this.setTranslateX(100);
        this.setTranslateY(30);
        
        this.getChildren().add(gridpane);
    }
    
}
