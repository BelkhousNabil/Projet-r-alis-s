package rule;

import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Set;
import model.Element;
import model.Item;
import model.surEnsemble;
import view.CloseView;
import view.Data;

public class RulesHandler {

    private Set<Element> elements;
    private double minSupport;

    public RulesHandler(Set<Element> elements, double minSupport) {
        this.elements = elements;
        //this.minConfidence = minConfidence;
        this.minSupport = minSupport;
    }

    public List<Rule> handelExactRules() {
        List<Rule> result = new ArrayList<>();
        for (Element e : elements) {
            Set<Item> right = e.getFermeture();
            right.removeAll(e.getGenerator());
            if (!right.isEmpty()) {
                Rule r = new Rule(e.getGenerator(), right);
                r.setSupport(e.getSupport());
                r.setConfidence(1);
                
                
                CloseView.dummyMacData.add(new Data(r.getLeftToString(), r.getRightToString(), r.getSupportToString(), r.getConfidenceToString(), r.getLiftToStirng() ));
                
                result.add(r);
            }
        }
        return result;
    }

    /**
     * Génère des règles approximatives (dont la confiance est comprise
     * entre minConfidence et 1).
     * @pre
     *      Génération des sur-ensembles fermés
     * @return 
     *      Une liste de règles
     */
    public List<Rule> handelApproxRules() {
        /*
         * pour chaque générateur g de {elements}
         *  Pour chaque superset de g
         *      nouvelle règle : g -> superSet - g / support(fermé(g)) / confiance = support(superset(g)) / support(fermé(g)) 
         *      si confiance < minConfidence ou confiance == 1, on n'enregistre pas la règle
         */
        generateSuperSets();
        List<Rule> result = new ArrayList<>();
        for (Element e : elements) {
            for (surEnsemble superSet : e.getSurEnsembles()) {
                Set<Item> right = new HashSet<>();
                right.addAll(superSet.getSurEnsemble());
                right.removeAll(e.getGenerator());
                Rule r = new Rule(e.getGenerator(), right);
                r.setSupport(superSet.getSupport());
                r.setConfidence(superSet.getSupport() / e.getSupport());
                if ((r.getSupport() > minSupport)) {
                	
                	CloseView.dummyMacData2.add(new Data(r.getLeftToString(), r.getRightToString(), r.getSupportToString(), r.getConfidenceToString(), r.getLiftToStirng() ));
                    result.add(r);
                }
            }
        }
        return result;
    }

    private void generateSuperSets() {
        for (Element e : elements) {
            for (Element el : elements) {
                if (el.getFermeture().containsAll(e.getGenerator())
                        && !e.getFermeture().equals(el.getFermeture())) {
                    e.addSurEnsemble(new surEnsemble(el.getFermeture(), el.getSupport()));
                }
            }
        }
    }
}
