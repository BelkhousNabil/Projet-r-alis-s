package model;

import java.util.Objects;

/**
 * La Classe Item repr&eacutesente un Item
 * @author Anouar & Nabil
 *
 */
public class Item implements Comparable<Object> {

    private String name;

    /**
     * Constructeur de Item
     * @param name
     */
    public Item(String name) {
        this.name = name;
    }

    /**
     * getName Getter de name
     * @return name
     */
    public String getName() {
        return this.name;
    }

    @Override
    public int hashCode() {
        int hash = 7;
        hash = 71 * hash + Objects.hashCode(this.name);
        return hash;
    }

    @Override
    public boolean equals(Object o) {
    	return (o instanceof Item)
                && ((Item) o).getName().equals(this.getName());
    }

    @Override
    public String toString() {
        return this.name;
    }

    @Override
    public int compareTo(Object o) {
        Item i = (Item) o;
        return (i.getName().compareTo(this.getName()));
    }
}
