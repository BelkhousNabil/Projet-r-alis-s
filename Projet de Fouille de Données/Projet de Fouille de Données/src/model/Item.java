package model;

import java.util.Objects;

/**
 * Représente un élément d'un itemset par une
 * chaîne et son support.
 */
public class Item implements Comparable<Object> {

    private String name;
    private double support;

    public Item(String name) {
        this.name = name;
    }

    public Item(String name, double support) {
        this.name = name;
        this.support = support;
    }

    public double getSupport() {
        return this.support;
    }

    public String getName() {
        return this.name;
    }

    @Override
    public int hashCode() {
        int hash = 7;
        hash = 71 * hash + Objects.hashCode(this.name);
        hash = 71 * hash + (int) (Double.doubleToLongBits(this.support) ^ (Double.doubleToLongBits(this.support) >>> 32));
        return hash;
    }

    @Override
    public boolean equals(Object o) {
        return (o instanceof Item)
                && ((Item) o).getName().equals(this.getName())
                && ((Item) o).getSupport() == this.getSupport();
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
