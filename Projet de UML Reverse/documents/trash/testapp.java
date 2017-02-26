import javafx.application.Application;
import javafx.event.EventHandler;
import javafx.scene.Group;
import javafx.scene.Scene;
import javafx.scene.SnapshotParameters;
import javafx.scene.input.*;
import javafx.scene.paint.Color;
import javafx.scene.shape.Rectangle;
import javafx.scene.shape.Shape;
import javafx.stage.Stage;


public class testapp extends Application {

    public static void main(String[] args) {
        Application.launch(args);
    }

    @Override
    public void start(Stage stage) {
        stage.setTitle("Hello Drag And Drop");


        //System.out.println(com.sun.javafx.runtime.VersionInfo.getRuntimeVersion());


        Group root = new Group();
        Scene scene = new Scene(root, 400, 200);


        final Rectangle source = new Rectangle(100, 100);
        addDragGesture(source);
        final Rectangle s = new Rectangle(100,100);
        s.setLayoutX(300);
        addDragGesture(s);





        scene.setOnDragOver(new EventHandler<DragEvent>() {
            public void handle(DragEvent event) {
                System.out.println("onDragOver");
                System.out.println(event.getX() + "" + event.getY());
                Dragboard db = event.getDragboard();
                if (db.hasString()) {
                    System.out.println("accept transfer");
                    event.acceptTransferModes(TransferMode.ANY);
                }
                event.consume();
            }
        });
        scene.setOnDragEntered(new EventHandler<DragEvent>() {
            public void handle(DragEvent event) {

                System.out.println("onDragEntered");
                System.out.println(event.getX() + "" + event.getY());
                event.consume();
            }
        });


        scene.setOnDragDropped(new EventHandler<DragEvent>() {
            public void handle(DragEvent event) {
                System.out.println("onDragDropped");
                Dragboard db = event.getDragboard();
                boolean success = false;
                if (db.hasString()) {

                    success = true;
                }

                event.setDropCompleted(success);
                event.consume();
                System.out.println(event.getSource() + "" + event.getGestureSource());
                ((Shape) event.getGestureSource()).setLayoutX(event.getX());
                ((Shape) event.getGestureSource()).setLayoutY(event.getY());
              /*  source.setLayoutX(event.getX() );
                source.setLayoutY(event.getY());*/
            }
        });

        scene.setOnDragExited(new EventHandler<DragEvent>() {
            public void handle(DragEvent event) {
                System.out.println("onDragExited");
                System.out.println(event.getX() + "" + event.getY());
                event.consume();
            }
        });



        root.getChildren().add(source);
        root.getChildren().add(s);
        stage.setScene(scene);
        stage.show();

    }
    void addDragGesture(final Shape source) {
        source.setOnDragDetected(new EventHandler<MouseEvent>() {
            public void handle(MouseEvent event) {
                System.out.println("onDragDetected");

                Dragboard db = source.startDragAndDrop(TransferMode.ANY);
                SnapshotParameters sp = new SnapshotParameters();
                sp.setFill(Color.TRANSPARENT);
                db.setDragView(source.snapshot(sp, null));
                ClipboardContent content = new ClipboardContent();
                content.putString("Rectangle draggable");
                db.setContent(content);
                event.consume();
            }
        });


        source.setOnDragDone(new EventHandler<DragEvent>() {
            public void handle(DragEvent event) {
                System.out.println("onDragDone");
                System.out.println(event.getX() + "" + event.getY());
                event.consume();
            }
        });
    }
}