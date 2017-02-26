package serie02;

import java.beans.PropertyChangeListener;
import java.beans.PropertyChangeSupport;
import java.beans.PropertyVetoException;
import java.beans.VetoableChangeListener;
import java.beans.VetoableChangeSupport;
import java.util.ArrayList;
import java.util.EnumMap;
import java.util.LinkedList;
import java.util.List;
import java.util.Map;
import java.util.Set;

public class StdPodiumManager<E extends Drawable> implements PodiumManager<E> {

// ATTRIBUTS
    /**
     * Dernier ordre communiqu� au gestionnaire
     */
    private Order lastOrder;

    /**
     * map des quatre podiums g�r�s par ce gestionnaire
     */
    private final Map<Rank, Podium<E>> podiums;

    /**
     * nombre d'ordres ex�cut�s depuis le d�but de la partie
     */
    private int shotsNb;

    /**
     * temps �coul� entre le d�but et la fin de la partie
     */
    private long timeDelta;

    /**
     * faux tant que la partie n'est pas termin�e, vrai � partir de l'instant o�
     * elle se termine
     */
    private boolean finished;

    private final Set<E> drawables;

    private VetoableChangeSupport vetoableCS;
    private PropertyChangeSupport propertyCS;

// CONSTRUCTEURS
    /**
     * @inv <pre>
     *     getPodiums() != null
     *     forall r:Rank : getPodiums().get(r) != null
     *     getShotsNb() >= 0
     *     getTimeDelta() >= 0
     *     !isFinished() ==> getTimeDelta() == 0 </pre>
     *
     * @cons $ARGS$ Set<E> drawables $PRE$ (drawables != null &&
     * drawables.size() >= 2 $POST$ les mod�les des 2+2 podiums sont initialis�s
     * al�atoirement avec les �l�ments de drawables
     */
    public StdPodiumManager(Set<E> drawables) {
        //Contract.checkCondition(drawables != null, "L'ensemble en param�tre est vide.");
        //Contract.checkCondition(drawables.size() >= 2, "L'ensemble en param�tre a une taille inf�rieur � deux.");
        this.drawables = drawables;
        podiums = new EnumMap<Rank, Podium<E>>(Rank.class);
        for (Rank r : Rank.values()) {
            podiums.put(r, new Podium<E>(new StdPodiumModel<E>()));
        }
        reinit();
    }

// REQUETES
    @Override
    public Order getLastOrder() {
        return lastOrder;
    }

    @Override
    public Map<Rank, Podium<E>> getPodiums() {
        return podiums;
    }

    @Override
    public int getShotsNb() {
        return shotsNb;
    }

    @Override
    public long getTimeDelta() {
        return (System.nanoTime() - timeDelta) / 1000000000;
    }

    @Override
    public boolean isFinished() {
        return finished;
    }

// COMMANDES
    @Override
    public void addPropertyChangeListener(String propName,
            PropertyChangeListener lst) {
        if (lst == null) {
            return;
        }
        if (propertyCS == null) {
            propertyCS = new PropertyChangeSupport(this);
        }
        propertyCS.addPropertyChangeListener(propName, lst);
    }

    @Override
    public void addVetoableChangeListener(VetoableChangeListener lst) {
        if (vetoableCS == null) {
            vetoableCS = new VetoableChangeSupport(this);
        }
        vetoableCS.addVetoableChangeListener(lst);
    }

    @Override
    public void executeOrder(Order o) {
        Podium<E> podL;
        PodiumModel<E> pmL;
        E elem;
        E elem2;

        Podium<E> podR;
        PodiumModel<E> pmR;

        switch (o) {
            case LO:
                podL = podiums.get(Rank.WRK_LEFT);
                pmL = podL.getModel();
                elem = pmL.top();
                pmL.removeTop();

                podR = podiums.get(Rank.WRK_RIGHT);
                pmR = podR.getModel();
                pmR.addTop(elem);
                break;
            case KI:
                podR = podiums.get(Rank.WRK_RIGHT);
                pmR = podR.getModel();
                elem = pmR.top();
                pmR.removeTop();

                podL = podiums.get(Rank.WRK_LEFT);
                pmL = podL.getModel();
                pmL.addTop(elem);
                break;
            case MA:
                podL = podiums.get(Rank.WRK_LEFT);
                pmL = podL.getModel();
                elem = pmL.bottom();
                pmL.removeBottom();
                pmL.addTop(elem);
                break;
            case NI:
                podR = podiums.get(Rank.WRK_RIGHT);
                pmR = podR.getModel();
                elem = pmR.bottom();
                pmR.removeBottom();
                pmR.addTop(elem);
                break;
            case SO: {
                try {
                    fireVetoableChange("lastOrder", null, getLastOrder());
                    System.out.println("coucou");
                    podL = podiums.get(Rank.WRK_LEFT);
                    pmL = podL.getModel();
                    elem = pmL.top();
                    pmL.removeTop();

                    podR = podiums.get(Rank.WRK_RIGHT);
                    pmR = podR.getModel();
                    elem2 = pmR.top();
                    pmR.removeTop();

                    pmL.addTop(elem2);
                    pmR.addTop(elem);
                   
                } catch (PropertyVetoException ex) {
                    return;
                }
                 break;
            }

        }
        lastOrder = o;
        ++shotsNb;
        firePropertyChange("lastOrder", null, o);
        //System.out.println(podiums.get(Rank.WRK_LEFT).getClass() == podiums.get(Rank.OBJ_LEFT).getClass());
        if ((podiums.get(Rank.WRK_LEFT)).equals((podiums.get(Rank.OBJ_LEFT)))
                && (podiums.get(Rank.WRK_RIGHT)).equals((podiums.get(Rank.OBJ_RIGHT)))) {
            finished = true;
            firePropertyChange("finished", false, true);
        }
    }

    @Override
    public void reinit() {
        timeDelta = System.nanoTime();
        finished = false;
        changePodiumModels();
    }

    @Override
    public void removePropertyChangeListener(PropertyChangeListener lst) {
        if (propertyCS == null) {
            return;
        }
        propertyCS.removePropertyChangeListener(lst);
    }

    @Override
    public void removeVetoableChangeListener(VetoableChangeListener lst) {
        if (vetoableCS == null) {
            return;
        }
        vetoableCS.removeVetoableChangeListener(lst);
    }

    protected void firePropertyChange(String propertyName, Object oldValue, Object newValue) {
        if (propertyCS == null
                || (oldValue != null && newValue != null && oldValue.equals(newValue))) {
            return;
        }
        propertyCS.firePropertyChange(propertyName, oldValue, newValue);
    }

    protected void fireVetoableChange(String name, Object oldValue, Object newValue)
            throws PropertyVetoException {
        if (propertyCS == null
                || (oldValue != null && newValue != null && oldValue.equals(newValue))) {
            return;
        }
        vetoableCS.fireVetoableChange(name, oldValue, newValue);
    }

// OUTILS
    /**
     * Construit les 4 s�quences d'�l�ments de E, puis les 4 mod�les de podiums
     * bas�s sur ces s�quences. La concat�nation des deux premi�res s�quences
     * est une permutation des �l�ments de drawables. La concat�nation des deux
     * derni�res s�quences est aussi une permutation des �l�ments de drawables.
     * Il se peut que les permutations soient identiques.
     */
    private void changePodiumModels() {
        List<List<E>> lst = createRandomElements();
        lst.addAll(createRandomElements());
        for (Rank r : Rank.values()) {
            podiums.get(r).setModel(
                    new StdPodiumModel<E>(
                            lst.get(r.ordinal()),
                            drawables.size()
                    )
            );
        }
    }

    /**
     * Construit une s�quence de deux s�quences al�atoires d'�l�ments de E, �
     * partir de l'ensemble drawables, un peu comme in distribue des cartes : -
     * on commence par m�langer les cartes, - puis on les distribue au hasard,
     * une par une, en deux tas.
     */
    private List<List<E>> createRandomElements() {
        final double ratio = 0.5;
        List<E> elements = new LinkedList<E>(drawables);
        List<E> list = new ArrayList<E>(drawables.size());
        for (int i = drawables.size(); i > 0; i--) {
            int k = ((int) (Math.random() * i));
            list.add(elements.get(k));
            elements.remove(k);
        }
        List<E> elemsL = new ArrayList<E>(drawables.size());
        List<E> elemsR = new ArrayList<E>(drawables.size());
        for (E e : list) {
            if (Math.random() < ratio) {
                elemsL.add(e);
            } else {
                elemsR.add(e);
            }
        }
        ArrayList<List<E>> result = new ArrayList<List<E>>(2);
        result.add(elemsL);
        result.add(elemsR);
        return result;
    }
}
