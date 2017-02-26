/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package melordi;

import java.util.Arrays;
import javafx.event.EventHandler;
import javafx.scene.Parent;
import javafx.scene.effect.Reflection;
import javafx.scene.input.KeyEvent;
import javafx.scene.paint.Color;
import javafx.scene.paint.CycleMethod;
import javafx.scene.paint.LinearGradient;
import javafx.scene.paint.Stop;
import javafx.scene.shape.Rectangle;
;

/**
 *
 * @author anto
 */
public class Keyboard extends Parent {
    
    private final Rectangle keyboard;
    private final Key[] keys;
    
    public Keyboard(Instru instru) {
        keyboard = new Rectangle();
        keys = new Key[]{
            new Key("U",50,20,60, instru),
            new Key("I",128,20,62, instru),
            new Key("O",206,20,64, instru),
            new Key("P",284,20,65, instru),
            new Key("J",75,98,67, instru),
            new Key("K",153,98,69, instru),
            new Key("L",231,98,71, instru),
            new Key("M",309,98,72, instru)
        };
        
        defineKeyboardSize();
        placeComposant();
        defineStyle();
        createController();
        this.getChildren().add(keyboard);
        this.getChildren().addAll(Arrays.asList(keys));
    }
    
// OUTILS
    private void defineKeyboardSize() {
        keyboard.setWidth(400);
        keyboard.setHeight(200);
        keyboard.setArcWidth(30);
        keyboard.setArcHeight(30);
    }
    private void placeComposant() {
        this.setTranslateX(50);//on positionne le groupe plutôt que le rectangle
        this.setTranslateY(250);
    }
    
    private void defineStyle() {
        keyboard.setFill(new LinearGradient(0f, 0f, 0f, 1f, true, CycleMethod.NO_CYCLE,
                new Stop[] {
                    new Stop(0, Color.web("#333333")),
                    new Stop(1, Color.web("#000000"))
                }
            )
        );
        Reflection r = new Reflection();//on applique un effet de réflection
        r.setFraction(0.25);
        r.setBottomOpacity(0);
        r.setTopOpacity(0.5);
        keyboard.setEffect(r);
    }
    
    private void createController() {    
        setOnKeyPressed(new EventHandler<KeyEvent>(){
            @Override
            public void handle(KeyEvent ke){
                for (Key key: keys){
                    if(key.getLetter().equals(ke.getText().toUpperCase() ) )
                        key.pressed();
                }
            }
        });
        
        setOnKeyReleased(new EventHandler<KeyEvent>(){
            @Override
            public void handle(KeyEvent ke){
                for (Key key: keys){
                    if(key.getLetter().equals(ke.getText().toUpperCase() ) )
                        key.released();
                }
            }
        });
    }
}
