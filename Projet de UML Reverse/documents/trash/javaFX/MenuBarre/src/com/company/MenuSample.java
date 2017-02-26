package com.company;

/**
 * Created by BELKHOUS on 04/02/2016.
 * Proposition of a Menu bar with icons
 */

import javafx.application.Application;

import javafx.scene.Group;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.paint.Color;
import javafx.stage.Stage;

public class MenuSample extends Application {

    /**
     * Start of JavaFX application demonstrating menu support.
     *
     * @param stage Primary stage.
     */
    @Override
    public void start(final Stage stage)
    {
        stage.setTitle("MenuBar Proposition for UML Project");
        final Group rootGroup = new Group();
        final Scene scene = new Scene(rootGroup, 800, 400, Color.WHEAT);

        observerOpen observatorOpen = new observerOpen();
        ObserverSave observatorSave = new ObserverSave();
        ObserverSaveAs observatorSaveAs = new ObserverSaveAs();
        ObserverNew observatorNew = new ObserverNew();
        ObserverImport observatorImport = new ObserverImport();
        ObserverExport observatorExport = new ObserverExport();
        ObserverExit observatorExit = new ObserverExit();
        ObserverEntity observatorEntity = new ObserverEntity();
        ObserverRelation observatorRelation = new ObserverRelation();
        ObserverHelp observatorHelp = new ObserverHelp();

        menu items = new menu();

        items.addObserver(observatorOpen);
        items.addObserver(observatorSave);
        items.addObserver(observatorSaveAs);
        items.addObserver(observatorNew);
        items.addObserver(observatorImport);
        items.addObserver(observatorExport);
        items.addObserver(observatorExit);
        items.addObserver(observatorEntity);
        items.addObserver(observatorRelation);
        items.addObserver(observatorHelp);

        final MenuBar menuBar = items.buildMenuBarWithMenus(stage.widthProperty());
        rootGroup.getChildren().add(menuBar);
        stage.setScene(scene);
        stage.show();
    }

    /**
     * Main executable function for running examples.
     *
     * @param arguments Command-line arguments: none expected.
     */
    public static void main(final String[] arguments)
    {

        Application.launch(arguments);
    }

}