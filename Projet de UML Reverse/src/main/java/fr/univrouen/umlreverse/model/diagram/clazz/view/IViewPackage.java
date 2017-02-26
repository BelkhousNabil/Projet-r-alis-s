package fr.univrouen.umlreverse.model.diagram.clazz.view;

import java.beans.PropertyVetoException;
import java.io.Serializable;
import java.util.Set;

import fr.univrouen.umlreverse.model.diagram.clazz.visitor.IClassVisitor;
import fr.univrouen.umlreverse.model.diagram.common.IObservable;
import fr.univrouen.umlreverse.model.diagram.common.IStylizable;

/**
 * A view on a package
 */
public interface IViewPackage extends Serializable, IStylizable, IObservable {

    /**
     * The diagram
     */
    IClassDiagram getDiagram();

    /**
     * getter of name
     * @return the name
     */
    String getName();

    /**
     * The parent folder
     */
    IViewPackage getPackage();

    /**
     * The absolute name
     */
    String getAbsoluteName();

    /**
     * getter of packages
     * @return the packages
     */
    Set<IViewPackage> getPackages();

    /**
     * getter of all the entities
     * @return the listEntities
     */
    Set<IViewEntity> getEntities();

    // METHODS

    /**
     * addPackage allows to add packages
     */
    void addPackage(IViewPackage viewPackage) throws PropertyVetoException;

    /**
     * removePackage allows to remove packages
     */
    void removePackage(IViewPackage viewPackage);

    /**
     * addEntity allows to add entities
     * @param entity
     * 		the entity to add
     */
    void addEntity(IViewEntity entity);

    /**
     * removeEntity allows to remove entities
     * @param entity
     * 		the entity to remove
     */
    void removeEntity(IViewEntity entity);

    /**
     * setter of parent
     */
    void setPackage(IViewPackage parent) throws PropertyVetoException;

    /**
     * setter of name
     * @param namePackage the name to set
     */
    void setName(String namePackage) throws PropertyVetoException;

    void accept(IClassVisitor visitor);
}
