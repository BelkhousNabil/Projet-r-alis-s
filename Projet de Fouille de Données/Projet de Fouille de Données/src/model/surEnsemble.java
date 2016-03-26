package model;

import java.util.Objects;
import java.util.Set;

/**
 * Représente un sur-ensemble
 */
public class surEnsemble {
    private Set<Item> superset;
    private double support;
    
    public surEnsemble(Set<Item> superset, double support) {
        this.support = support;
        this.superset = superset;
    }

    public Set<Item> getSurEnsemble() {
        return superset;
    }

    public void setgetSurEnsemble(Set<Item> superset) {
        this.superset = superset;
    }

    public double getSupport() {
        return support;
    }

    public void setSupport(double support) {
        this.support = support;
    }
    
    @Override
    public boolean equals(Object o) {
        return (o instanceof surEnsemble) &&
                this.getSurEnsemble().equals(((surEnsemble) o).getSurEnsemble()) &&
                this.getSupport() == ((surEnsemble) o).getSupport();
    }

    @Override
    public int hashCode() {
        int hash = 7;
        hash = 89 * hash + Objects.hashCode(this.superset);
        hash = 89 * hash + (int) (Double.doubleToLongBits(this.support) ^ (Double.doubleToLongBits(this.support) >>> 32));
        return hash;
    }
    
    @Override
    public String toString() {
        String str = "";
        str += "{";
        for (Item i : getSurEnsemble()) {
            str += i;
        }
        str += "}";
        return str;
    }
}
