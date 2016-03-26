package model;

import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Map;
import java.util.Set;

import rule.Rule;
import rule.RulesHandler;
import utils.Parser;

public class Close {


    private Map<Integer, List<Item>> data;
    private List<Element> listItems;
    private Map<Item, List<Item>> relationItems;
    private double minSupport;
    private double lift;


    public Close(double minSupport) {
        this.minSupport = minSupport;
        //this.minConfidence = minConfidence;
    }
    
    /**
     * Calcule la première fermeture, générateur, et support à partir des données parsées (FF1).
     * @return
     */
    public Set<Element> calcFermeture() {
		List<Item> generators = new ArrayList<Item>();//Liste des générateurs
		List<Double> support = new ArrayList<Double>();//Liste des supports
		List<Set<Item>> fermeture = new ArrayList<Set<Item>>();//Liste des fermetures
		Set<Element> retTable = new HashSet<Element>(); //Table à retourner (FF1)
		
		//Calcule les générateurs
		for (int k:data.keySet()) {
			for (Item l : data.get(k)) {
				if (!generators.contains(l)) {
					generators.add(l);
					fermeture.add(new HashSet<Item>());
					support.add(0.0);
				}
			}						
		}
		
		 //generators FF1
		 
		
		for (int k : data.keySet()) {			
			for (Item l : data.get(k)) {	
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
			Set<Item> set = new HashSet<Item>();
			set.add(i);
			Element e = new Element(set);
			e.setFermeture(fermeture.get(generators.indexOf(i)));
			e.setSupport(support.get(generators.indexOf(i))/(data.size()));
			if (e.getSupport() >= minSupport) {
				retTable.add(e);
			}
		}
		// ret FF1: retTable
		
		listItems = new ArrayList<Element>();
		for (Element i : retTable) {
			listItems.add(i);
		}
		
		return retTable;
	}
    
    /**
     * Méthode pour savoir si il existe une table suivante FF(k+1)
     * @param table
     * @return booleen
     */
    public boolean EmptyNewGenerators(Set<Element> table) {
    	List<Element> list = new ArrayList<Element>(table);
    	List<Set<Item>> newGenerators = new ArrayList<Set<Item>>();
    	//Création des nouveaux générateurs possibles
    	for (Element e : list) {    		
    		for (int i = list.indexOf(e) + 1; i < list.size(); i++) {
    			Set<Item> stock = new HashSet<Item>();
    			stock.clear();
    			stock.addAll(e.getGenerator());
    			stock.addAll(list.get(i).getGenerator());
    			newGenerators.add(stock);
    		}
    	}
    	//Suppression des générateurs présents dans la fermeture précédente.
    	List<Set<Item>> removeList = new ArrayList<Set<Item>>();
    	for (Element e : list) {
    		for (Set<Item> s : newGenerators) {
    			if (e.getFermeture().containsAll(s)) {
    				removeList.add(s);
    			}
    		}
    	}    	
    	for (Set<Item> r : removeList) {
    		newGenerators.remove(r);
    	}
    	return newGenerators.isEmpty();
    }
    
    /**
     * Méthode pour calculer la fermeture jusqu'à ce qu'il n'y ait plus de générateurs possibles.
     * @param table
     * @return
     */
    public Set<Element> calcElementFermeture(Set<Element> table) {
    	List<Element> list = new ArrayList<Element>(table);
    	List<Set<Item>> newGenerators = new ArrayList<Set<Item>>();
    	//Création des nouveaux générateurs possibles
    	for (Element e : list) {    		
    		for (int i = list.indexOf(e) + 1; i < list.size(); i++) {
    			Set<Item> stock = new HashSet<Item>();    			
    			stock.addAll(e.getGenerator());
    			stock.addAll(list.get(i).getGenerator());
    			newGenerators.add(stock);
    		}
    	}
    	//Suppression des générateurs présents dans la fermeture précédente.
    	List<Set<Item>> removeList = new ArrayList<Set<Item>>();
    	for (Element e : list) {
    		for (Set<Item> s : newGenerators) {
    			if (e.getFermeture().containsAll(s)) {
    				removeList.add(s);
    			}
    		}
    	}    	
    	for (Set<Item> r : removeList) {
    		newGenerators.remove(r);
    	}

    	List<Set<Item>> newFermeture = new ArrayList<Set<Item>>();
    	List<Double> newSupport = new ArrayList<Double>();
    	for (@SuppressWarnings("unused") Set<Item> k : newGenerators) {
    		newFermeture.add(new HashSet<Item>());
    		newSupport.add(0.0);
    	}
    	for (Set<Item> o : newGenerators) {
    		for (int k : data.keySet()) {
    			if (data.get(k).containsAll(o)) {
    				newSupport.set(newGenerators.indexOf(o), newSupport.get(newGenerators.indexOf(o)) + 1);

    				if (newFermeture.get(newGenerators.indexOf(o)).isEmpty()) {

    					newFermeture.get(newGenerators.indexOf(o)).addAll(data.get(k));
    				} else {

    					newFermeture.get(newGenerators.indexOf(o)).retainAll(data.get(k));
    				}
    			}    			
    		}
    	}
    	
    	// newGenerators: newGenerators
    	//newFermeture : newFermeture
    	//newSupport : newSupport
    	
    	Set<Element> retTable = new HashSet<Element>();
    	for (Set<Item> i : newGenerators) {			
			Element e = new Element(i);
			e.setFermeture(newFermeture.get(newGenerators.indexOf(i)));
			e.setSupport(newSupport.get(newGenerators.indexOf(i))/(data.size()));
			if (e.getSupport() >= minSupport) {				
				retTable.add(e);
			}
		}

    	
    	for (Element i : retTable) {
			listItems.add(i);
		}
    	
    	if (EmptyNewGenerators(retTable)) {    	
    		return retTable;
    	} else {
    		calcElementFermeture(retTable);
    	}
		return retTable;
    	
    }

    public void loadData(Parser parser) {
        this.data = parser.parseFile();
        this.calcFermeture();
        calcElementFermeture(this.calcFermeture());  
    }


    public String generateRelations() {
        //Phase 3 - Génération des règles
        String str = "";
        Set<Element> elements = new HashSet<Element>(listItems);
        RulesHandler re = new RulesHandler(elements, minSupport);
        List<Rule> approxRules = re.handelApproxRules();
        List<Rule> exactRules = re.handelExactRules();
        
        str += "Règles d'association exactes\n";
        for (Rule r : exactRules) {
            str += r + "\n";
        }
        str += "\nRègles d'association approximatives\n";
        for (Rule r : approxRules) {
            str += r + "\n";
        }
        // Phase 3 - end generation rules
        return str;
    }

    public void setLift(double lift) {
        this.lift = lift;
    }

    public double getLift() {
        return lift;
    }

    public void setMinSupport(double minSupport) {
        this.minSupport = minSupport;
    }


    public double getMinSupport() {
        return this.minSupport;
    }
    

    public Map<Integer, List<Item>> getData() {
        return this.data;
    }


    public Map<Item, List<Item>> getRelationItems() {
        return this.relationItems;
    }

}
