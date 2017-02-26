/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package melordi;

import javafx.application.Application;
import javafx.scene.Group;
import javafx.scene.Scene;
import javafx.scene.paint.Color;
import javafx.stage.Stage;

/**
 *
 * @author anto
 */
public class Melordi extends Application {
    
    @Override
    public void start(Stage primaryStage) { 
        primaryStage.setTitle("Melordi");
        Group root = new Group();
        Scene scene = new Scene(root, 500, 500, Color.WHITE); 
        
        Instru instru = new Instru();
        Keyboard keyboard = new Keyboard(instru);
        ChangeInstru changeinstru = new ChangeInstru(instru);
        Sound sound = new Sound(keyboard);
        Metronome metronome = new Metronome();
        
        instru.getVolume().bind(sound.getSlider().valueProperty());
         
        root.getChildren().add(keyboard);
        root.getChildren().add(changeinstru);  
        root.getChildren().add(sound);
        root.getChildren().add(metronome);
        
        primaryStage.setScene(scene);
        primaryStage.show();
        keyboard.requestFocus();

    }

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        launch(args);
    }
}
