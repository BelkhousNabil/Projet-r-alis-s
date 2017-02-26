package com.mycompany.maventest;

import java.awt.event.MouseListener;
import javafx.application.Application;
import static javafx.application.Application.launch;
import javafx.event.Event;
import javafx.event.EventHandler;
import javafx.scene.Group;
import javafx.scene.Scene;
import javafx.scene.image.WritableImage;
import javafx.scene.input.ClipboardContent;
import javafx.scene.input.DataFormat;
import javafx.scene.input.Dragboard;
import javafx.scene.input.MouseEvent;
import javafx.scene.input.TransferMode;
import javafx.scene.paint.Color;
import javafx.scene.paint.Paint;
import javafx.scene.shape.Circle;
import javafx.scene.shape.Rectangle;
import javafx.scene.text.Text;
import javafx.stage.Stage;


public class MainApp extends Application {
    
    @Override
    public void start(Stage stage) throws Exception {
        stage.setWidth(800);
        stage.setHeight(600);
        stage.setTitle("umlReverse");

        Group root = new Group();
        Scene scene = new Scene(root);
        scene.setFill(Color.SKYBLUE);
        
        final Circle sun = new Circle(60, Color.web("yellow", 0.8));
        sun.setCenterX(600);
        sun.setCenterY(100);
        
        final Circle circle = new Circle(250, 200, 50); 
        circle.setFill(Color.RED); 
        root.getChildren().add(circle);

      
        circle.addEventHandler(MouseEvent.MOUSE_CLICKED, (MouseEvent e) -> {
           circle.setFill(Color.BLUE);
        });
        
        sun.addEventHandler(MouseEvent.MOUSE_CLICKED, (MouseEvent e) -> {
           sun.setCenterX(e.getSceneX());
           sun.setCenterY(e.getSceneY());
        });
        
        
        
       
        sun.setOnDragDetected(mouseEvent -> {
                System.out.println("DnD detecté."); 
          
                final Dragboard dragBroard = sun.startDragAndDrop(TransferMode.ANY); 
                // Remlissage du contenu. 
                final ClipboardContent content = new ClipboardContent(); 
                // Exporter en tant que texte. 
                content.putString("Un cercle jaune."); 
                // Exporter en tant que couleur ARGB. 
                DataFormat paintFormat = DataFormat.lookupMimeType(Paint.class.getName()); 
                paintFormat = (paintFormat == null) ? new DataFormat(Paint.class.getName()) : paintFormat; 
                final Color color = (Color) sun.getFill(); 
                final int red = (int) (255 * color.getRed()); 
                final int green = (int) (255 * color.getGreen()); 
                final int blue = (int) (255 * color.getBlue()); 
                final int alpha = (int) (255 * color.getOpacity()); 
                final int argb = alpha << 24 | red << 16 | green << 8 | blue << 0; 
                content.put(paintFormat, argb); 
                // Exporter en tant qu'image.        
                final WritableImage capture = sun.snapshot(null, null); 
                content.putImage(capture); 
                // 
                dragBroard.setContent(content); 
                mouseEvent.consume(); 
        });
        
        circle.setOnDragOver(dragEvent -> { 
            final Dragboard dragBroard = dragEvent.getDragboard(); 
            DataFormat paintFormat = DataFormat.lookupMimeType(Paint.class.getName()); 
            paintFormat = (paintFormat == null) ? new DataFormat(Paint.class.getName()) : paintFormat; 
            if (dragEvent.getGestureSource() != circle && dragBroard.hasContent(paintFormat)) { 
                // Indique les modes de transfert autorisés sur cette destination. 
                dragEvent.acceptTransferModes(TransferMode.COPY); 
            } 
            dragEvent.consume(); 
        });
        
        circle.setOnDragDropped(dragEvent -> { 
            boolean success = false; 
            try { 
                final Dragboard dragBroard = dragEvent.getDragboard(); 
                DataFormat paintFormat = DataFormat.lookupMimeType(Paint.class.getName()); 
                paintFormat = (paintFormat == null) ? new DataFormat(Paint.class.getName()) : paintFormat; 
                final int argb = (Integer) dragBroard.getContent(paintFormat); 
                final double opacity = ((argb >> 24) & 0xFF) / 255.0; 
                final int red = (argb >> 16) & 0xFF; 
                final int green = (argb >> 8) & 0xFF; 
                final int blue = (argb >> 0) & 0xFF; 
                final Color fill = Color.rgb(red, green, blue, opacity); 
                circle.setFill(fill); 
                success = true; 
            } catch (Exception ex) { 
            
            } finally { 
                dragEvent.setDropCompleted(success); 
                dragEvent.consume(); 
            } 
        });
        
        circle.setOnDragEntered(dragEvent -> { 
            final Dragboard dragBroard = dragEvent.getDragboard(); 
            DataFormat paintFormat = DataFormat.lookupMimeType(Paint.class.getName()); 
            paintFormat = (paintFormat == null) ? new DataFormat(Paint.class.getName()) : paintFormat; 
            if (dragEvent.getGestureSource() != circle && dragBroard.hasContent(paintFormat)) { 
                circle.setStroke(Color.GREEN); 
            } else { 
                circle.setStroke(Color.ORANGE); 
            } 
            circle.setStrokeWidth(10); 
            dragEvent.consume(); 
        }); 
        circle.setOnDragExited(dragEvent -> { 
            circle.setStroke(null); 
            circle.setStrokeWidth(0); 
            dragEvent.consume(); 
        });
        

        
        // création du sol
        Rectangle ground = new Rectangle(0, 400, 800, 200);
        ground.setFill(Color.GREEN);
        Text t = new Text(10, 50, "This is a test");
        root.getChildren().add(t);

        // ajout de tous les éléments de la scène
        root.getChildren().add(sun);
        root.getChildren().add(ground);
        
        // ajout de la scène sur l'estrade
        stage.setScene(scene);
        // ouvrir le rideau
        stage.show();
    }
    
// PRIVATE
    
    
   
    /**
     * The main() method is ignored in correctly deployed JavaFX application.
     * main() serves only as fallback in case the application can not be
     * launched through deployment artifacts, e.g., in IDEs with limited FX
     * support. NetBeans ignores main().
     *
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        launch(args);
    }

}
