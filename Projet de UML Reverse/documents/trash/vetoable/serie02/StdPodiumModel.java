package serie02;

import java.util.ArrayList;
import java.util.List;
import javax.swing.JSlider;

import javax.swing.event.ChangeEvent;
import javax.swing.event.ChangeListener;
import javax.swing.event.EventListenerList;

/**
 * Impl�mentation standard de PodiumModel.
 */


public class StdPodiumModel<E> implements PodiumModel<E> {
    // ATTRIBUTS
    private List<E> data;
    private int capacity;
    private final EventListenerList listenerList;
    private final ChangeEvent event;

    // CONSTRUCTEURS
    public StdPodiumModel(List<E> init, int capacity) {
        if (init == null) {
            throw new IllegalArgumentException();
        }
        if (containsNullValue(init)) {
            throw new IllegalArgumentException();
        }
        this.capacity = capacity;
        data = new ArrayList<E>(init);
        listenerList = new EventListenerList();
        event = new ChangeEvent(this);
    }

    public StdPodiumModel() {
        this(new ArrayList<E>(), 0);
    }

// REQUETES
    @Override
    public E bottom() {
        if (size() <= 0) {
            throw new IllegalStateException();
        }
        return data.get(0);
    }

    @Override
    public E elementAt(int i) {
        if (i < 0 || i >= capacity()) {
            throw new IllegalArgumentException();
        }
        if (i < size()) {
            return data.get(i);
        } else {
            return null;
        }
    }

    @Override
    public boolean equals(Object o) {
        if ((o == null) || (o.getClass() != getClass())) {
            return false;
        }
        StdPodiumModel<E> arg = (StdPodiumModel<E>) o;
        boolean result = (arg.capacity == capacity
                && data.size() == arg.data.size());
        for (int i = 0; result && (i < data.size()); i++) {
            result = data.get(i).equals(arg.data.get(i));
        }
        return result;
    }

    @Override
    public int capacity() {
        return capacity;
    }

    @Override
    public int size() {
        return data.size();
    }

    @Override
    public E top() {
        if (size() <= 0) {
            throw new IllegalStateException();
        }
        return data.get(data.size() - 1);
    }

    @Override
    public int hashCode() {
        final int prime = 31;
        int result = 1;
        result = prime * result + capacity;
        result = prime * result + data.hashCode();
        return result;
    }

    @Override
    public String toString() {
        String res = "[";
        for (int i = 0; i < size(); i++) {
            res += data.get(i) + "|";
        }
        return capacity + "/" + res + "]";
    }

    // COMMANDES
    @Override
    public void addChangeListener(ChangeListener cl) {
        if (cl == null) {
            throw new IllegalArgumentException();
        }
        listenerList.add(ChangeListener.class, cl);
    }

    @Override
    public void addTop(E elem) {
        if (elem == null) {
            throw new IllegalArgumentException();
        }
        if (size() >= capacity()) {
            throw new IllegalStateException(
                    "Ne peut ajouter en haut : la structure est pleine"
            );
        }
        data.add(elem);
        fireStateChanged();
    }

    @Override
    public void removeBottom() {
        if (size() <= 0) {
            throw new IllegalStateException(
                    "Ne peut retirer en bas : la structure est vide"
            );
        }
        data.remove(0);
        fireStateChanged();
    }

    @Override
    public void removeChangeListener(ChangeListener cl) {
        if (cl == null) {
            throw new IllegalArgumentException();
        }
        listenerList.remove(ChangeListener.class, cl);
    }

    @Override
    public void removeTop() {
        if (size() <= 0) {
            throw new IllegalStateException(
                    "Ne peut retirer en haut : la structure est vide"
            );
        }
        data.remove(size() - 1);
        fireStateChanged();
    }

    // OUTILS
    /**
     * Pr�vient les ChangeListener associ�s que ce mod�le a chang�.
     */
    protected void fireStateChanged() {
        ChangeListener[] listeners = listenerList.getListeners(ChangeListener.class);
        for (ChangeListener lst : listeners) {
            lst.stateChanged(event);
        }
    }

    private boolean containsNullValue(List<E> list) {
        for (E e : list) {
            if (e == null) {
                return true;
            }
        }
        return false;
    }
}
