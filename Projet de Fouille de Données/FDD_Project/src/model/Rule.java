package model;

import java.util.Set;

/**
 * La Classe Rule repr&eacutesente les r&egravegles d'associations
 * 
 * @author Anouar & Nabil
 *
 */
public class Rule {
    private Set<Item> left;
    private Set<Item> right;
    private double support;
    private double confience;
    
    /**
     * Contructeur
     * @param left
     * @param right
     */
    public Rule(Set<Item> left, Set<Item> right) {
        this.left = left;
        this.right = right;
    }
    
    /**
     * getLeftToString Permet de retourn&eacute la partie gauche de la r&egravegle sous forme de chaine de caract&egravere
     * @return str
     */
    public String getLeftToString(){
    	String str = "";
        for (Item i : getLeft()) {
            str += i.toString();
        }
        return str;
    }
    
    /**
     * getLeft retoune la partie gauche de la r&egravegle
     * @return left
     */
    public Set<Item> getLeft() {
        return left;
    }
    
    /**
     * getRight retoune la partie droite de la r&egravegle
     * @return right
     */
    public Set<Item> getRight() {
        return right;
    }

    /**
     * getRightToString Permet de retourn&eacute la partie droite de la r&egravegle sous forme de chaine de caract&egravere
     * @return str
     */
    public String getRightToString(){
    	String str = "";
    	for (Item i : getRight()) {
            str += i.toString();
        }
    	return str;
    }
    
    /**
     * getSupport Getter du support
     * @return support
     */
    public double getSupport() {
        return support;
    }

    /**
     * setSupport Setter du support
     * @param support
     */
    public void setSupport(double support) {
        this.support = support;
    }

    /**
     * getconfience Getter de la confiance
     * @return confience
     */
    public double getConfience() {
        return confience;
    }
    
    /**
     * setconfience Setter de la confiance
     * @param confience
     */
    public void setConfience(double confience) {
        this.confience = confience;
    }
    
    /**
     * getSupportToString Permet de retourner le support sous forme de chaine de caract&egravere avec un arondie de 2 chiffres
     * @return support
     */
    public String getSupportToString() {
        return "" + (Math.round(100d*support)/100d);
    }

    /**
     * getConfienceToString Permet de retourner la confience sous forme de chaine de caract&egravere avec un arondie de 2 chiffres
     * @return confience
     */
    public String getConfienceToString() {
        return "" + Math.round(100d*confience)/100d ;
    }

    /**
     * getLiftToStirng Permet de retourner le lift sous forme de chaine de caract&egravere avec un arondie de 2 chiffres
     * @return lift
     */
    public String getLiftToStirng(){
    	return "" + Math.round(100d*confience/support)/100d;
    }
    
    
    @Override
    public String toString() {
        String str = getLeftToString() + "\t->\t" + getRightToString();
        
        return str + "\t(s=" + getSupportToString() + ", c=" +
                getConfienceToString()  +
                ", l="+ getLiftToStirng()  +")";
    }
    
}
