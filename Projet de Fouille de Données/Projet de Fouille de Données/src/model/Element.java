package model;

import java.util.HashSet;
import java.util.Set;

/**
 *  Représente un ensemble de générateurs, son ensemble fermé,
 *  ses sur-ensembles et son support.
 */
public class Element {
    private Set<Item> generator;
    private Set<Item> closure;
    private Set<surEnsemble> superSets;
    private double support;

    public Element(Set<Item> generator) {
        this.generator = generator;
        this.superSets = new HashSet<>();
    }
    
    public Element(Set<Item> generator, Set<Item> closure, double support) {
        this.generator = generator;
        this.closure = closure;
        this.support = support;
        this.superSets = new HashSet<>();
    }
    
    public Set<Item> getGenerator() {
        return generator;
    }

    public void setGenerator(Set<Item> generator) {
        this.generator = generator;
    }
    
    public Set<surEnsemble> getSurEnsembles() {
        return this.superSets;
    }
    
    public void addSurEnsemble(surEnsemble ss) {
        this.superSets.add(ss);
    }
    
    public void setSurEnsemble(Set<surEnsemble> superSets) {
        this.superSets = superSets;
    }
    
    public double getSupport() {
        return support;
    }

    public void setSupport(double support) {
        this.support = support;
    }
    
    public void setFermeture(Set<Item> closure) {
        this.closure = closure;
    }
    
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
