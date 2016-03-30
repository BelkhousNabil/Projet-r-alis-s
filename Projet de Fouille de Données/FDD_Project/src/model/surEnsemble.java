package model;

import java.util.Objects;
import java.util.Set;

/**
 * La Classe surEnsemble represente les Sur-Ensembles
 * @author Anouar & Nabil
 *
 */
public class surEnsemble {
    private Set<Item> surEnsemble;
    private double support;
    
    /**
     * Constructeur
     * @param surEnsemble
     * @param support
     */
    public surEnsemble(Set<Item> surEnsemble, double support) {
        this.support = support;
        this.surEnsemble = surEnsemble;
    }

    /**
     * getSurEnsemble getter de SurEsemble
     * @return surEnsemble
     */
    public Set<Item> getSurEnsemble() {
        return surEnsemble;
    }
    
    /**
     * setSurEnsemble Setter de surEnsemble
     * @param surEnsemble
     */
    public void setSurEnsemble(Set<Item> surEnsemble) {
        this.surEnsemble = surEnsemble;
    }

    /**
     * getSupport Getter de support
     * @return support
     */
    public double getSupport() {
        return support;
    }

    /**
     * setSupport Setter de support
     * @param support
     */
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
        hash = 89 * hash + Objects.hashCode(this.surEnsemble);
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
