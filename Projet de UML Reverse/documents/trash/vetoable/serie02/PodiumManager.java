package serie02;

import java.beans.PropertyChangeListener;
import java.beans.VetoableChangeListener;
import java.util.Map;

/**
 * @inv <pre>
 *     getPodiums() != null
 *     forall r:Rank : getPodiums().get(r) != null
 *     getShotsNb() >= 0
 *     getTimeDelta() >= 0
 *     !isFinished() ==> getTimeDelta() == 0 </pre>
 * @cons
 *     $ARGS$ Set<E> drawables
 *     $PRE$ (drawables != null && drawables.size() >= 2
 *     $POST$
 *         les mod�les des 2+2 podiums sont initialis�s al�atoirement
 *         avec les �l�ments de drawables
 */
public interface PodiumManager<E extends Drawable> {

    /**
     * Les dispositions des podiums sur la fen�tre :
     *   - WRK_LEFT  : podium gauche de la configuration de d�part ;
     *   - WRK_RIGHT : podium droit de la configuration de d�part ;
     *   - OBJ_LEFT  : podium gauche de la configuration objectif ;
     *   - OBJ_RIGHT : podium droit de la configuration objectif.
     */
    enum Rank { WRK_LEFT, WRK_RIGHT, OBJ_LEFT, OBJ_RIGHT }
    
    /**
     * Les ordres pass�s par le dompteur aux animaux.
     */
    enum Order {
        LO("Lo : G>D"),
        KI("Ki : G<D"),
        MA("Ma :  ^G"),
        NI("Ni :  ^D"),
        SO("So : <->");
        private String label;
        Order(String lbl) { label = lbl; }
        public String toString() { return label; }
    }
    
    // REQUETES
    
    /**
     * Le dernier ordre donn�.
     * Vaut null en d�but de partie.
     */
    Order getLastOrder();

    /**
     * Les quatre podiums g�r�s par ce gestionnaire.
     */
    Map<Rank, Podium<E>> getPodiums();

    /**
     * Le nombre d'ordres donn�s au cours d'une partie.
     */
    int getShotsNb();

    /**
     * L'intervalle de temps entre le d�but d'une partie et la fin.
     * Vaut 0 tant que la partie n'est pas finie.
     */
    long getTimeDelta();

    /**
     * Indique si une partie en cours est finie.
     */
    boolean isFinished();

    // COMMANDES

    /**
     * @pre <pre>
     *     lst != null </pre>
     * @post <pre>
     *     lst a �t� ajout� � la liste des �couteurs
     *     de la propri�t� propName </pre>
     */
    void addPropertyChangeListener(String propName, PropertyChangeListener lst);

    /**
     * @pre <pre>
     *     lst != null </pre>
     * @post <pre>
     *     lst a �t� ajout� � la liste des �couteurs </pre>
     */
    void addVetoableChangeListener(VetoableChangeListener lst);

    /**
     * Ex�cute l'ordre o sur ce gestionnaire.
     * @pre <pre>
     *     o != null </pre>
     * @post <pre>
     *     les actions conformes � l'ordre o ont �t� ex�cut�es sur les podiums
     *       g�r�s par ce gestionnaire </pre>
     */
    void executeOrder(Order o);

    /**
     * R�initialise ce gestionnaire.
     * @post <pre>
     *     les podiums g�r�s par ce gestionnaire ont un nouveau mod�le
     *       g�n�r� al�atoirement
     *     getShotsNb() == 0
     *     getTimeDelta() == 0
     *     getLastOrder() == null </pre>
     */
    void reinit();

    /**
     * @pre <pre>
     *     lst != null </pre>
     * @post <pre>
     *     lst a �t� retir� de la liste des �couteurs </pre>
     */
    void removePropertyChangeListener(PropertyChangeListener lst);

    /**
     * @pre <pre>
     *     lst != null </pre>
     * @post <pre>
     *     lst a �t� retir� de la liste des �couteurs </pre>
     */
    void removeVetoableChangeListener(VetoableChangeListener lst);
}
