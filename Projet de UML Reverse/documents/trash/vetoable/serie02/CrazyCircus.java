package serie02;

import java.awt.BorderLayout;
import java.awt.Dimension;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.beans.PropertyChangeEvent;
import java.beans.PropertyChangeListener;
import java.beans.PropertyVetoException;
import java.beans.VetoableChangeListener;
import java.util.EnumMap;
import java.util.Map;
import java.util.Set;

import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextArea;
import javax.swing.border.Border;

import serie02.PodiumManager.Order;
import serie02.PodiumManager.Rank;

public class CrazyCircus<E extends Drawable> {

// ATTRIBUTS
    private JFrame mainFrame;

    private Map<Order, JButton> orderButton;
    private JCheckBox autorisedSO;
    private JButton newGame;
    private JTextArea text;

    private final PodiumManager<E> model;

// CONSTRUCTEURS
    public CrazyCircus(Set<E> s) {
        model = new StdPodiumManager<E>(s);
        createView();
        placeComponant();
        createControler();
    }

// COMMANDES
    public void display() {
        mainFrame.pack();
        mainFrame.setLocationRelativeTo(null);
        mainFrame.setVisible(true);
    }

// OUTILS
    private void createView() {
        mainFrame = new JFrame();

        orderButton = new EnumMap<Order, JButton>(Order.class);
        for (Order o : Order.values()) {
            orderButton.put(o, new JButton(o.toString()));
        }

        autorisedSO = new JCheckBox();
        newGame = new JButton("Nouvelle Partie");
        text = new JTextArea();
        text.setEditable(false);
        text.setPreferredSize(new Dimension(100, 75));
    }

    private void placeComponant() {

        JPanel p = new JPanel(new GridLayout(1, 0));
        {
            Map<Rank, Podium<E>> map = model.getPodiums();
            for (Rank r : Rank.values()) {
                p.add(map.get(r));
            }
        }
        mainFrame.add(p);

        p = new JPanel();
        {
            JPanel q = new JPanel(new GridLayout(0, 1));
            {
                for (Order o : Order.values()) {
                    q.add(orderButton.get(o));
                }
                JPanel j = new JPanel();
                {
                    j.add(autorisedSO);
                    j.add(new JLabel("Autoriser SO"));
                }
                Border b = javax.swing.BorderFactory.createEtchedBorder();
                j.setBorder(b);
                q.add(j);
                q.add(newGame);
            }
            p.add(q);
        }
        mainFrame.add(p, BorderLayout.EAST);

        mainFrame.add(text, BorderLayout.SOUTH);
    }

    private void createControler() {
        mainFrame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

        model.addPropertyChangeListener("lastOrder", new PropertyChangeListener() {
            @Override
            public void propertyChange(PropertyChangeEvent evt) {
                text.append(((Order) model.getLastOrder()) + " ");
            }
        });

        model.addPropertyChangeListener("finished", new PropertyChangeListener() {
            @Override
            public void propertyChange(PropertyChangeEvent evt) {
                text.append("\ngagn� en " + model.getShotsNb()
                        + "coups et " + model.getTimeDelta() + " secondes");
                for (Order o : Order.values()) {
                    orderButton.get(o).setEnabled(false);
                }
            }
        });

        model.addVetoableChangeListener(new VetoableChangeListener() {

            @Override
            public void vetoableChange(PropertyChangeEvent evt)
                    throws PropertyVetoException {
                if (!autorisedSO.isSelected()) {
                    throw new PropertyVetoException("Impossible d'utiliser SO", evt);
                }
            }
        });

        orderButton.get(Order.MA).addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                model.executeOrder(Order.MA);
            }
        });

        orderButton.get(Order.KI).addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                model.executeOrder(Order.KI);
            }
        });

        orderButton.get(Order.LO).addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                model.executeOrder(Order.LO);
            }
        });

        orderButton.get(Order.NI).addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                model.executeOrder(Order.NI);
            }
        });

        orderButton.get(Order.SO).addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                model.executeOrder(Order.SO);
            }
        });

        newGame.addActionListener(new ActionListener() {

            @Override
            public void actionPerformed(ActionEvent e) {
                model.reinit();
                Map<Rank, Podium<E>> podiums = model.getPodiums();
                for (Rank r : Rank.values()) {
                    ((JPanel) podiums.get(r).getParent()).repaint();
                }
                text.setText("");
                for (Order o : Order.values()) {
                    orderButton.get(o).setEnabled(true);
                }
            }
        });
    }
}
