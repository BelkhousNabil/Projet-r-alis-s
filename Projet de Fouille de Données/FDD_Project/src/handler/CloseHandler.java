package handler;

import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Map;
import java.util.Set;

import model.Element;
import model.Item;
import model.Rule;
import model.surEnsemble;
import view.CloseView;
import view.Data;

/**
 * La Classe CloseHandler nous permet mettre en place l'algorithme CLOSE
 * @author Anouar & Nabil
 *
 */
public class CloseHandler {

	
    private Map<Integer, List<Item>> data;
    private List<Element> listItems;
    private Map<Item, List<Item>> relationItems;
    private double minSupport;
    private double lift;

    /**
     * Constructeur
     * 
     * @param minSupport
     */
    public CloseHandler(double minSupport , Map<Integer, List<Item>> data) {
        this.minSupport = minSupport;
        this.data = data;
        listItems = new ArrayList<Element>() ;
    }
    
    /**
     * runClose permet de lancer l'algorithme CLOSE
     */
    public void runClose() {
    	generateFirstFermeture();
    	
    	List<Element> listElementsForRetriveNewGenerators = listItems;
    	List<Set<Item>> newGenerators = null;
    	
    	while(!(newGenerators = generateNewGenerators(listElementsForRetriveNewGenerators)).isEmpty()){
    		listElementsForRetriveNewGenerators = genereteElementFermeture(newGenerators);
    	}
    }
    
    /**
     * generateFirstFermeture permet de calculer la premi&egravere fermeture, g&eacuten&eacuterateur, et le support &agrave partir des donn&eacutees (FF1).
     */
    public void generateFirstFermeture() {
		List<Item> generators = new ArrayList<Item>();//Liste des g&eacuten&eacuterateurs
		List<Double> support = new ArrayList<Double>();//Liste des supports
		List<Set<Item>> fermeture = new ArrayList<Set<Item>>();//Liste des fermetures
		
		//Calcule des condidats
		for (int k:data.keySet()) {
			for (Item l : data.get(k)) {
				if (!generators.contains(l)) {
					generators.add(l);
					fermeture.add(new HashSet<Item>());
					support.add(0.0);
				}
				
				//generators FF1
				support.set(generators.indexOf(l), support.get(generators.indexOf(l)) + 1);
				if (fermeture.get(generators.indexOf(l)).isEmpty()) {
					fermeture.get(generators.indexOf(l)).addAll(data.get(k));
				} else {					
					fermeture.get(generators.indexOf(l)).retainAll(data.get(k));
				}			
			}						
		}
		
		//fermeture FF1
		for (Item i : generators) {
			int index = generators.indexOf(i);
			Set<Item> set = new HashSet<Item>();
			set.add(i);
			Element e = new Element(set);
			e.setFermeture(fermeture.get(index));
			e.setSupport(support.get(index)/(data.size()));
			if (e.getSupport() > minSupport) {
				listItems.add(e);
			}
		}
	}
    
    /**
     * generateNewGenerators permet de generer les g&eacuten&eacuterateurs des it&eacuterations > 1
     * @param listElements
     * @return newGenerators
     */
    public List<Set<Item>> generateNewGenerators(List<Element> listElements) {
    	List<Set<Item>> newGenerators = new ArrayList<Set<Item>>();
    	//Cr&eacuteation des nouveaux g&eacuten&eacuterateurs possibles
    	for (Element e : listElements) {
    		for (int i = listElements.indexOf(e) + 1; i < listElements.size(); i++) {
    			Set<Item> condidats = new HashSet<Item>();
    			condidats.addAll(e.getGenerator());
    			condidats.addAll(listElements.get(i).getGenerator());
    			newGenerators.add(condidats);
    			for (Element e2 : listElements) {
        			if (e2.getFermeture().containsAll(condidats)) {
        				newGenerators.remove(condidats);
        				break;
        			}
        			
        		}
    			
    		}
    	}
    	
    	return newGenerators;
    }
    
    /**
     * genereteElementFermeture permet de calculer les fermeture jusqu'a ce qu'il n'y ait plus de g&eacuten&eacuterateurs
     * @param newGenerators
     * @return ArrayList<Element>(table)
     */
    public List<Element> genereteElementFermeture(List<Set<Item>> newGenerators) {
    	List<Set<Item>> newFermeture = new ArrayList<Set<Item>>();
    	List<Double> newSupport = new ArrayList<Double>();
    	for ( @SuppressWarnings("unused") Set<Item> k : newGenerators) {
    		newFermeture.add(new HashSet<Item>());
    		newSupport.add(0.0);
    	}
    	
    	for(int i = 0 ; i< newGenerators.size(); i++){
    		Set<Item> o = newGenerators.get(i);
    		for (int k : data.keySet()) {
    			if (data.get(k).containsAll(o)) {
    				newSupport.set(i, newSupport.get(i) + 1);
    				if (newFermeture.get(i).isEmpty()) {

    					newFermeture.get(i).addAll(data.get(k));
    				} else {

    					newFermeture.get(i).retainAll(data.get(k));
    				}
    			}    			
    		}
    	}
    	
    	//newGenerators: newGenerators
    	//newFermeture : newFermeture
    	//newSupport : newSupport	
    	Set<Element> table = new HashSet<Element>();
    	for (Set<Item> i : newGenerators) {			
			Element e = new Element(i);
			e.setFermeture(newFermeture.get(newGenerators.indexOf(i)));
			e.setSupport(newSupport.get(newGenerators.indexOf(i))/(data.size()));
			if (e.getSupport() > minSupport) {				
				table.add(e);
			}
		}

    	listItems.addAll(table);
    	
		return new ArrayList<Element>(table);
    }

    /**
     * generateRelations permet d'afficher les r&egravegles g&eacuten&eacuter&eacutees
     * @return str
     */
    public String generateRelations() {
        //Phase 3 - G&eacuten&eacuteration des r&egravegles
        String str = "";
        Set<Element> elements = new HashSet<Element>(listItems);
        List<Rule> approxRules = handelApproxRules(elements);
        List<Rule> exactRules = handelExactRules(elements);
        
        str += "R&egravegles d'association exactes\n";
        for (Rule r : exactRules) {
            str += r + "\n";
        }
        str += "\nR&egravegles d'association approximatives\n";
        for (Rule r : approxRules) {
            str += r + "\n";
        }
        // Phase 3 - end generation rules
        return str;
    }

    /**
     * handelExactRules Permet de g&eacuten&eacuterer les r&egravegles de confiance = 1
     * @param elements
     * @return result
     */
    public List<Rule> handelExactRules(Set<Element> elements) {
        List<Rule> result = new ArrayList<>();
        for (Element e : elements) {
            Set<Item> right = e.getFermeture();
            right.removeAll(e.getGenerator());
            if (!right.isEmpty()) {
                Rule r = new Rule(e.getGenerator(), right);
                r.setSupport(e.getSupport());
                r.setConfience(1);
                CloseView.dummyMacData.add(new Data(r.getLeftToString(), r.getRightToString(), r.getSupportToString(), r.getConfienceToString(), r.getLiftToStirng() ));
                result.add(r);
            }
        }
        return result;
    }
    
    /**
     * handelApproxRules Permet de g&eacuten&eacuterer les r&egravegles de confiance < 1
     * @param elements
     * @return
     */
    public List<Rule> handelApproxRules(Set<Element> elements) {
    	generateSurEnsembles(elements);
        List<Rule> result = new ArrayList<>();
        for (Element e : elements) {
            for (surEnsemble superSet : e.getSurEnsembles()) {
                Set<Item> right = new HashSet<>();
                right.addAll(superSet.getSurEnsemble());
                right.removeAll(e.getGenerator());
                Rule r = new Rule(e.getGenerator(), right);
                r.setSupport(superSet.getSupport());
                r.setConfience(superSet.getSupport() / e.getSupport());
                if ((r.getSupport() > minSupport)) {
                	CloseView.dummyMacData2.add(new Data(r.getLeftToString(), r.getRightToString(), r.getSupportToString(), r.getConfienceToString(), r.getLiftToStirng() ));
                	result.add(r);
                }
            }
        }
        return result;
    }

    /**
     * generateSurEnsembles Permet de g&eacuten&eacuterer les sur-ensembles
     * @param elements
     */
    private void generateSurEnsembles(Set<Element> elements) {
        for (Element e : elements) {
            for (Element el : elements) {
                if (el.getFermeture().containsAll(e.getGenerator())
                        && !e.getFermeture().equals(el.getFermeture())) {
                    e.addSurEnsemble(new surEnsemble(el.getFermeture(), el.getSupport()));
                }
            }
        }
    }
    
    /**
     * setLift Setter de lift
     * @param lift
     */
    public void setLift(double lift) {
        this.lift = lift;
    }

    /**
     * getLift Getter de lift
     * @return lift
     */
    public double getLift() {
        return lift;
    }

    /**
     * setMinSupport Setter de minSupport
     * @param minSupport
     */
    public void setMinSupport(double minSupport) {
        this.minSupport = minSupport;
    }

    /**
     * getMinSupport Getter de minSupport
     * @return minSupport
     */
    public double getMinSupport() {
        return this.minSupport;
    }
    
    /**
     * getData Getter of data
     * @return
     */
    public Map<Integer, List<Item>> getData() {
        return this.data;
    }

    /**
     * getRelationItems Getter de RelationItems
     * @return relationItems
     */
    public Map<Item, List<Item>> getRelationItems() {
        return this.relationItems;
    }

}
