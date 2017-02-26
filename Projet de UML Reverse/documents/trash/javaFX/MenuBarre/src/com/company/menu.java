package com.company;

import javafx.beans.property.ReadOnlyDoubleProperty;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.scene.control.*;
import javafx.scene.image.ImageView;
import javafx.scene.input.KeyCode;
import javafx.scene.input.KeyCodeCombination;
import javafx.scene.input.KeyCombination;

import java.util.Observable;

/**
 * Created by BELKHOUS on 08/02/2016.
 */
public class menu extends Observable {

    public static String type;

    /**
     * Creation of the menu bar
     * @param menuWidthProperty
     * @return MenuBar
     */
    public MenuBar buildMenuBarWithMenus(final ReadOnlyDoubleProperty menuWidthProperty)
    {
        final MenuBar menuBar = new MenuBar();

        // Prepare left-most 'File' drop-down menu
        final Menu fileMenu = new Menu("File");
        MenuItem open = MenuItemBuilder.create().
                text("Open").onAction(
                new EventHandler<ActionEvent>()
                {
                    @Override public void handle(ActionEvent e)
                    {
                        System.out.println("Hello it's Open!");
                        type= "open";
                        //Determine changes
                        setChanged();
                        //send a notification
                        notifyObservers(this);
                    }
                }).accelerator( new KeyCodeCombination(KeyCode.O, KeyCombination.CONTROL_DOWN)).build();

        // add the icon
        open.setGraphic(new ImageView(getClass().getResource("open.png").toExternalForm()));

        fileMenu.getItems().add(open);
        MenuItem save = MenuItemBuilder.create().
                text("Save").onAction(
                new EventHandler<ActionEvent>()
                {
                    @Override public void handle(ActionEvent e)
                    {
                        System.out.println("Hello it's Save!");
                        type= "save";
                        //Determine changes
                        setChanged();
                        //send a notification
                        notifyObservers(this);

                    }
                }).accelerator( new KeyCodeCombination(KeyCode.S, KeyCombination.CONTROL_DOWN)).build();
        // add the icon
        save.setGraphic(new ImageView(getClass().getResource("save.png").toExternalForm()));

        fileMenu.getItems().add(save);
        MenuItem saveAs = MenuItemBuilder.create().
                text("Save As").onAction(
                new EventHandler<ActionEvent>()
                {
                    @Override public void handle(ActionEvent e)
                    {
                        System.out.println("Hello it's Save As!");
                        type= "saveAs";
                        //Determine changes
                        setChanged();
                        //send a notification
                        notifyObservers(this);

                    }
                }).accelerator( new KeyCodeCombination(KeyCode.A, KeyCombination.CONTROL_DOWN)).build();
        // add the icon
        saveAs.setGraphic(new ImageView(getClass().getResource("saveAs.png").toExternalForm()));

        fileMenu.getItems().add(saveAs);
        fileMenu.getItems().add(new SeparatorMenuItem());
        MenuItem impor = MenuItemBuilder.create().
                text("Import").onAction(
                new EventHandler<ActionEvent>()
                {
                    @Override public void handle(ActionEvent e)
                    {
                        System.out.println("Hello it's Import!");
                        type= "import";
                        //Determine changes
                        setChanged();
                        //send a notification
                        notifyObservers(this);

                    }
                }).accelerator( new KeyCodeCombination(KeyCode.I, KeyCombination.CONTROL_DOWN)).build();
        // add the icon
        impor.setGraphic(new ImageView(getClass().getResource("import.png").toExternalForm()));

        fileMenu.getItems().add(impor);
        MenuItem expo = MenuItemBuilder.create().
                text("Export").onAction(
                new EventHandler<ActionEvent>()
                {
                    @Override public void handle(ActionEvent e)
                    {
                        System.out.println("Hello it's Export!");
                        type= "export";
                        //Determine changes
                        setChanged();
                        //send a notification
                        notifyObservers(this);

                    }
                }).accelerator( new KeyCodeCombination(KeyCode.P, KeyCombination.CONTROL_DOWN)).build();
        // add the icon
        expo.setGraphic(new ImageView(getClass().getResource("export.png").toExternalForm()));

        fileMenu.getItems().add(expo);
        fileMenu.getItems().add(new SeparatorMenuItem());
        MenuItem exit = MenuItemBuilder.create().
                text("Exit").onAction(
                new EventHandler<ActionEvent>()
                {
                    @Override public void handle(ActionEvent e)
                    {
                        System.out.println("Hello it's Exit!");
                        type= "exit";
                        //Determine changes
                        setChanged();
                        //send a notification
                        notifyObservers(this);

                    }
                }).accelerator( new KeyCodeCombination(KeyCode.X, KeyCombination.CONTROL_DOWN)).build();
        // add the icon
        exit.setGraphic(new ImageView(getClass().getResource("exit.png").toExternalForm()));

        fileMenu.getItems().add(exit);
        menuBar.getMenus().add(fileMenu);

        // Prepare 'Examples' drop-down menu
        final Menu examplesMenu = new Menu("Edit");
        MenuItem news = MenuItemBuilder.create().
                text("New").onAction(
                new EventHandler<ActionEvent>()
                {
                    @Override public void handle(ActionEvent e)
                    {
                        System.out.println("Hello it's New!");
                        type= "new";
                        //Determine changes
                        setChanged();
                        //send a notification
                        notifyObservers(this);

                    }
                }).accelerator( new KeyCodeCombination(KeyCode.N, KeyCombination.CONTROL_DOWN)).build();
        // add the icon
        news.setGraphic(new ImageView(getClass().getResource("new.png").toExternalForm()));

        examplesMenu.getItems().add(news);
        Menu add = new Menu("Add");
        MenuItem entity = MenuItemBuilder.create().
                text("Entity").onAction(
                new EventHandler<ActionEvent>()
                {
                    @Override public void handle(ActionEvent e)
                    {
                        System.out.println("Hello it's Entity!");
                        type= "entity";
                        //Determine changes
                        setChanged();
                        //send a notification
                        notifyObservers(this);

                    }
                }).accelerator( new KeyCodeCombination(KeyCode.E, KeyCombination.CONTROL_DOWN)).build();
        MenuItem relation = MenuItemBuilder.create().
                text("Relation").onAction(
                new EventHandler<ActionEvent>()
                {
                    @Override public void handle(ActionEvent e)
                    {
                        System.out.println("Hello it's Relation!");
                        type= "relation";
                        //Determine changes
                        setChanged();
                        //send a notification
                        notifyObservers(this);

                    }
                }).accelerator(new KeyCodeCombination(KeyCode.R, KeyCombination.CONTROL_DOWN)).build();

        examplesMenu.getItems().add(add);
        add.getItems().add(entity);
        add.getItems().add(relation);
        menuBar.getMenus().add(examplesMenu);

        // Prepare 'Help' drop-down menu
        final Menu helpMenu = new Menu("Help");

        helpMenu.getItems().add(new SeparatorMenuItem());
        final MenuItem about = MenuItemBuilder.create().
                text("About").onAction(
                new EventHandler<ActionEvent>()
                {
                    @Override public void handle(ActionEvent e)
                    {
                        System.out.println("Hello it's About!");
                        type= "about";
                        //Determine changes
                        setChanged();
                        //send a notification
                        notifyObservers(this);

                    }
                }).accelerator(new KeyCodeCombination(KeyCode.A, KeyCombination.CONTROL_DOWN)).build();
        // add the icon
        about.setGraphic(new ImageView(getClass().getResource("about.png").toExternalForm()));

        helpMenu.getItems().add(about);

        menuBar.getMenus().add(helpMenu);

        // bind width of menu bar to width of associated stage
        menuBar.prefWidthProperty().bind(menuWidthProperty);

        return menuBar;
    }
}
