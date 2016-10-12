package model;

import java.util.HashSet;
import java.util.Set;

/**
 * La classe Element repr&eacutesente ses g&eacuten&eacuterateurs, ses fermetures, ses sur-Ensembles et son support
 * @author Anouar & Nabil
 *
 */
public class Element {
    private Set<Item> generator;
    private Set<Item> closure;
    private Set<surEnsemble> superSets;
    private double support;

    /**
     * Constructeur d'un Element
     * @param generator
     */
    public Element(Set<Item> generator) {
        this.generator = generator;
        this.superSets = new HashSet<>();
    }
    
    /**
     * Constructeur d'un Element
     * @param generator
     * @param closure
     * @param support
     */
    public Element(Set<Item> generator, Set<Item> closure, double support) {
        this.generator = generator;
        this.closure = closure;
        this.support = support;
        this.superSets = new HashSet<>();
    }
    
    /**
     * getGenerator Getter de Generator
     * @return generator 
     */
    public Set<Item> getGenerator() {
        return generator;
    }

    /**
     * setGenerator Setter de Generator
     * @param generator
     */
    public void setGenerator(Set<Item> generator) {
        this.generator = generator;
    }
    
    /**
     * getSurEnsembles Getter de SurEnsembles
     * @return superSets
     */
    public Set<surEnsemble> getSurEnsembles() {
        return this.superSets;
    }
    
    /**
     * addSurEnsemble permet d'ajouter des sur-ensembles
     * @param ss
     */
    public void addSurEnsemble(surEnsemble ss) {
        this.superSets.add(ss);
    }
    
    /**
     * setSurEnsemble Setter de SurEnsemble
     * @param superSets
     */
    public void setSurEnsemble(Set<surEnsemble> superSets) {
        this.superSets = superSets;
    }
    
    /**
     * getSupport Getter de support
     * @return support
     */
    public double getSupport() {
        return support;
    }

    /**
     * setSupport Setter de Support
     * @param support
     */
    public void setSupport(double support) {
        this.support = support;
    }
    
    /**
     * setFermeture Setter de fermeture
     * @param closure
     */
    public void setFermeture(Set<Item> closure) {
        this.closure = closure;
    }
    
    /**
     * getFermeture Getter de fermeture
     * @return
     */
    public Set<Item> getFermeture() {
        return this.closure;
    }
    
    @Override
    public String toString() {
        String str = "";
        str += "G = {";
        for (Item i : generator) {
            str += i;
        }
        str += "}\tFF = {";
        for (Item i : closure) {
            str += i;
        }
        if (superSets != null) {
            str += "}\tSS = {";
            for (surEnsemble s : superSets) {
                str += s;
            }
        }
        str += "}";
        str += " (s="+ getSupport()+")";
        return str;
    }
}
