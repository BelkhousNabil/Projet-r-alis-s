package melordi;

import javafx.event.EventHandler;
import javafx.scene.Parent;
import javafx.scene.effect.Light;
import javafx.scene.effect.Light.Distant;
import javafx.scene.effect.Lighting;
import javafx.scene.input.MouseEvent;
import javafx.scene.paint.Color;
import javafx.scene.shape.Rectangle;
import javafx.scene.text.Font;
import javafx.scene.text.Text;

/**
 *
 * @author anto
 */
public class Key extends Parent {

    private final String letter;//letter de la touche, c'est une variable public pour qu'elle puisse être lue depuis les autres classes
    private final int positionX;
    private final int positionY;
    private Instru instru;
    private final int note;//note correspond au numéro MIDI de la note qui doit être jouée quand on appuie sur la touche

    private final Rectangle backGKey;
    private final Text letterKey;

    public Key(String l, int posX, int posY, int n, Instru instru) {
        letter = l;
        positionX = posX;
        positionY = posY;
        this.instru = instru;
        note = n;
        backGKey = new Rectangle(75, 75, Color.WHITE);
        letterKey = new Text(letter);
        
        placeComponent();
        createStyle();
        createController();
    }

// REQUETE
    public String getLetter() {
        return letter;
    }
    
// COMMANDE

    public void setInstru(Instru instru) {
        this.instru = instru;
    }
 
// OUTILS
    
    private void placeComponent() {
        
        backGKey.setArcHeight(10);
        backGKey.setArcWidth(10);
        this.getChildren().add(backGKey);//ajout du rectangle de fond de la touche
        
        letterKey.setX(25);
        letterKey.setY(45);
        this.getChildren().add(letterKey);//ajout de la letter de la touche

        this.setTranslateX(positionX);//positionnement de la touche sur le clavier
        this.setTranslateY(positionY);
    }

    private void createStyle() {
        letterKey.setFont(new Font(25));
        letterKey.setFill(Color.GREY);
        
        Distant light = new Light.Distant();
        light.setAzimuth(-45.0);
        Lighting li = new Lighting();
        li.setLight(light);
        backGKey.setEffect(li);
    }
    
    private void createController() {
        setOnMouseEntered(new EventHandler<MouseEvent>(){
            @Override
            public void handle(MouseEvent me){
                backGKey.setFill(Color.LIGHTGREY);
            }
        });
        
        setOnMouseExited(new EventHandler<MouseEvent>(){
            @Override
            public void handle(MouseEvent me){
                backGKey.setFill(Color.WHITE);
            }
        });
        
        this.setOnMousePressed(new EventHandler<MouseEvent>() {
            @Override
            public void handle(MouseEvent me){
                pressed();
            }
        });
        
        this.setOnMouseReleased(new EventHandler<MouseEvent>() {
            @Override
            public void handle(MouseEvent me){
                released();
            }
        });
    }
    
    public void pressed() {
        backGKey.setFill(Color.DARKGREY);
        this.setTranslateY(positionY+2);
        instru.note_on(note);
    }
    
    public void released(){
        backGKey.setFill(Color.WHITE);
        this.setTranslateY(positionY);
        instru.note_off(note);
    }
}