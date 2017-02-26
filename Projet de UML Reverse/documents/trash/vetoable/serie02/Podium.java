package serie02;

import java.awt.Color;
import java.awt.Dimension;
import java.awt.Graphics;

import javax.swing.BorderFactory;
import javax.swing.JComponent;
import javax.swing.border.EtchedBorder;
import javax.swing.event.ChangeEvent;
import javax.swing.event.ChangeListener;

/**
 * Composant graphique donnant une vue de PodiumModel. Le param�tre de type du
 * podium est un type implantant Drawable. Un podium poss�de un mod�le de type
 * PodiumModel<E> qui est une propri�t� li�e accessible en lecture-�criture.
 *
 * @inv <pre>
 *     getModel() != null </pre>
 */
public class Podium<E extends Drawable> extends JComponent {

    // ATTRIBUTS

    private static final Color NO_ANIMAL = Color.LIGHT_GRAY;
    private static final Color PODIUM_COLOR = Color.BLACK;
    private static final Color NO_PODIUM_COLOR = Color.WHITE;
    private static final int BASE_HEIGHT = 5;
    private static final int PODIUM_HEIGHT = 2 * BASE_HEIGHT;
    private static final int LEG_WIDTH = 7;
    private static final int MARGIN = 2;

    private PodiumModel<E> model;
    private final ChangeListener changeListener;

    // CONSTRUCTEURS
    /**
     * Un podium de mod�le pm.
     *
     * @pre <pre>
     *     pm != null </pre>
     *
     * @post <pre>
     *     getModel() == pm </pre>
     */
    public Podium(PodiumModel<E> pm) {
        //Contract.checkCondition(pm != null, "Le model est null.");
        changeListener = new ChangeListener() {
            @Override
            public void stateChanged(ChangeEvent e) {
                repaint();
            }
        };
        setModel(pm);
        setBorder(BorderFactory.createEtchedBorder(EtchedBorder.RAISED));
    }

    // REQUETES
    /**
     * Le mod�le de ce Podium.
     */
    public PodiumModel<E> getModel() {
        return model;
    }

    @Override
    public boolean equals(Object obj) {
        if ((obj == null) || (obj.getClass() != getClass())
                || !super.equals(obj)) {
            //System.out.println("Faux direct");
            return false;
        }
        Podium<E> o = (Podium<E>) obj;
        return o.getModel() == getModel();
    }

    @Override
    public int hashCode() {
        return model.hashCode();
    }

    // COMMANDES
    /**
     * Fixe un nouveau mod�le pour ce Podium.
     *
     * @pre <pre>
     *     m != null </pre>
     *
     * @post <pre>
     *     getModel() == m </pre>
     */
    public void setModel(PodiumModel<E> m) {
        //Contract.checkCondition(m != null, "Le model est null.");
        model = m;
        model.addChangeListener(changeListener);
        setPreferredSize(new Dimension(MARGIN * 2 + Drawable.ELEM_WIDTH, model.capacity() * Drawable.ELEM_HEIGHT + PODIUM_HEIGHT));
    }

    @Override
    protected void paintComponent(Graphics g) {
        super.paintComponent(g);
        int capacity = model.capacity();
        int size = model.size();
        int x = (getWidth() - Drawable.ELEM_WIDTH) / 2;
        int y = getHeight() - PODIUM_HEIGHT;
        // rectangle noir du bas
        // largeur = largeur d'un animal
        // hauteur = hauteur totale du podium, pieds compris
        g.setColor(PODIUM_COLOR);
        g.fillRect(x, y, Drawable.ELEM_WIDTH, PODIUM_HEIGHT);
        // rectangle blanc du bas
        // largeur = largeur d'un animal - largeur des pieds du podium
        // hauteur = moiti� de la hauteur totale du podium
        g.setColor(NO_PODIUM_COLOR);
        g.fillRect(
                x + LEG_WIDTH,
                y + PODIUM_HEIGHT - BASE_HEIGHT,
                Drawable.ELEM_WIDTH - 2 * LEG_WIDTH,
                BASE_HEIGHT
        );
        // les animaux
        for (int i = 0; i < size; i++) {
            y -= Drawable.ELEM_HEIGHT;
            model.elementAt(i).draw(g, x, y);
        }
        // le vide au-dessus des animaux
        g.setColor(NO_ANIMAL);
        int h = Drawable.ELEM_HEIGHT * (capacity - size);
        g.fillRect(x, y - h, Drawable.ELEM_WIDTH, h);
    }
}
