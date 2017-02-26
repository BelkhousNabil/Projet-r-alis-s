package fr.univrouen.umlreverse.model.diagram.clazz.view;

import fr.univrouen.umlreverse.model.diagram.clazz.visitor.IClassVisitor;
import fr.univrouen.umlreverse.model.diagram.common.Observable;
import fr.univrouen.umlreverse.model.diagram.util.IStyle;
import fr.univrouen.umlreverse.model.diagram.util.Style;
import fr.univrouen.umlreverse.util.Contract;

import java.beans.PropertyVetoException;
import java.util.HashSet;
import java.util.Map;
import java.util.Set;

/**
 * Basic implement to IViewPackage
 */
public class ViewPackage extends Observable implements IViewPackage {

    // ATTRIBUTES

    private final IClassDiagram diagram;
    private IViewPackage parent = null;
    private String name;
    private final Set<IViewPackage> packages = new HashSet<>();
    private final Set<IViewEntity> entities = new HashSet<>();

    // CONSTRUCTORS

    public ViewPackage(String name, IClassDiagram diagram) {
        this.diagram = diagram;
        this.name = name;
    }

    // REQUESTS


    @Override
    public boolean equals(Object o) {
        if (this == o) return true;
        if (!(o instanceof ViewPackage)) return false;

        ViewPackage that = (ViewPackage) o;
        return getAbsoluteName() != null ? getAbsoluteName().equals(that.getAbsoluteName()) : that.getAbsoluteName() == null;

    }

    @Override
    public int hashCode() {
        return getAbsoluteName() == null ? 0 : getAbsoluteName().hashCode();
    }

    @Override
    public IClassDiagram getDiagram() {
        return diagram;
    }

    @Override
    public String getName() {
        return null;
    }

    @Override
    public IViewPackage getPackage() {
        return parent;
    }

    @Override
    public String getAbsoluteName() {
        if (parent != null) {
            return parent.getAbsoluteName() + "." + getName();
        }
        return getName();
    }

    @Override
    public Set<IViewPackage> getPackages() {
        return packages;
    }

    @Override
    public Set<IViewEntity> getEntities() {
        return entities;
    }
    
    // METHODS

    @Override
    public void addPackage(IViewPackage viewPackage) throws PropertyVetoException {
        if (!packages.contains(viewPackage)) {
            Set<IViewPackage> old = new HashSet<>(packages);
            for (IViewPackage p : packages) {
                if (p.getName().equals(viewPackage.getName())) {
                    throw new PropertyVetoException("0x0001", null);
                }
            }
            packages.add(viewPackage);
            viewPackage.setPackage(this);
            firePropertyChange("PackageChanged", old, packages);
        }
    }

    @Override
    public void removePackage(IViewPackage viewPackage) {
        if (packages.contains(viewPackage)) {
            Set<IViewPackage> old = new HashSet<>(packages);
            packages.remove(viewPackage);
            try { viewPackage.setPackage(null); } catch (PropertyVetoException ignored) {}
            firePropertyChange("PackagesChanged", old, packages);
        }
    }

    @Override
    public void addEntity(IViewEntity entity) {
        if (!entities.contains(entity)) {
            Set<IViewEntity> old = new HashSet<>(entities);
            entities.add(entity);
            entity.setPackage(this);
            firePropertyChange("EntitiesChanged", old, entities);
        }
    }

    @Override
    public void removeEntity(IViewEntity entity) {

    }

    @Override
    public void setPackage(IViewPackage parent) throws PropertyVetoException {
        if (this.parent != parent) {
            IViewPackage old = this.parent;
            if (parent != null && !parent.getPackages().contains(this)) {
                parent.addPackage(this);
            }
            this.parent = parent;
            firePropertyChange("ParentChanged", old, parent);
        }
    }

    @Override
    public void setName(String namePackage) throws PropertyVetoException {
        Contract.check(namePackage != null);
        String old = name;
        if (!name.equals(namePackage)) {
            if (parent != null) {
                for (IViewPackage p : parent.getPackages()) {
                    if (p.getName().equals(namePackage)) {
                        throw new PropertyVetoException("0x0001", null);
                    }
                }
            }
            this.name = namePackage;
            firePropertyChange("nameChanged", old, name);
        }
    }

    @Override
    public IStyle getStyle() {
        IStyle style = new Style();
        style.putAll(diagram.getStyle("*", "*"));
        style.putAll(diagram.getStyle("package", "*"));
        style.putAll(diagram.getStyle("package", getAbsoluteName()));
        return style;
    }

    @Override
    public void addAllStyle(Map<String, String> keyValue) {
        Contract.check(keyValue != null);
        String id = getAbsoluteName();
        for (String key : keyValue.keySet()) {
            diagram.getStyle().addStyle("package", id, key, keyValue.get(key));
        }
    }

    @Override
    public void addStyle(String key, String value) {
        IStyle old = getStyle();
        diagram.getStyle().addStyle("package", getAbsoluteName(), key, value);
        firePropertyChange("StyleChanged", old, getStyle());
    }

    @Override
    public void removeStyle(String key) {
        IStyle old = getStyle();
        diagram.getStyle().removeStyle("package", getAbsoluteName(), key);
        firePropertyChange("StyleChanged", old, getStyle());
    }

    @Override
    public void clearStyle() {
        IStyle old = getStyle();
        diagram.getStyle().removeStyle("package", getAbsoluteName());
        firePropertyChange("StyleChanged", old, getStyle());
    }

    // TOOLS

    @Override
    public void accept(IClassVisitor visitor) {
        visitor.visit(this);
    }
}
