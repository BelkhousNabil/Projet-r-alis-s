package rule;

import java.util.Set;
import model.Item;

/**
 * Représente une règle d'association
 */
public class Rule {
    private Set<Item> left;
    private Set<Item> right;
    private double support;
    private double confidence;
    
    public Rule(Set<Item> left, Set<Item> right) {
        this.left = left;
        this.right = right;
    }
    
    public String getLeftToString(){
    	String str = "";
        for (Item i : getLeft()) {
            str += i.toString();
        }
        return str;
    }
    
    public Set<Item> getLeft() {
        return left;
    }
    
    public Set<Item> getRight() {
        return right;
    }

    public String getRightToString(){
    	String str = "";
    	for (Item i : getRight()) {
            str += i.toString();
        }
    	return str;
    }
    
    public double getSupport() {
        return support;
    }

    public void setSupport(double support) {
        this.support = support;
    }

    public double getConfidence() {
        return confidence;
    }
    
    public void setConfidence(double confidence) {
        this.confidence = confidence;
    }
    
    public String getSupportToString() {
        return "" + (Math.round(100d*support)/100d);
    }

    public String getConfidenceToString() {
        return "" + Math.round(100d*confidence)/100d ;
    }

    public String getLiftToStirng(){
    	return "" + Math.round(100d*confidence/support)/100d;
    }
    
    
    @Override
    public String toString() {
        String str = getLeftToString() + "\t->\t" + getRightToString();
        
        return str + "\t(s=" + getSupportToString() + ", c=" +
                getConfidenceToString()  +
                ", l="+ getLiftToStirng()  +")";
    }
    
}
