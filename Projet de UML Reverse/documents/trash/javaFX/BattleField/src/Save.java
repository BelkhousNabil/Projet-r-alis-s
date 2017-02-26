import java.io.*;

/**
 * Created by zeddycus on 04/02/16.
 */
public class Save {
    public static void saveObject(Person p) {
        File f = new File("person.objet");

        try
        {
            ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream(f));
            oos.writeObject (p);
            oos.close();
        }
        catch (IOException exception)
        {
            System.out.println ("Erreur lors de l'écriture : " + exception.getMessage());
        }
    }

    public static Person loadObject() {

        File f = new File ("person.objet");
        try
        {
            ObjectInputStream ois = new ObjectInputStream (new FileInputStream (f));
            Person p2 = (Person) ois.readObject();
            ois.close();

            System.out.println (p2);
            return p2;
        }
        catch (ClassNotFoundException exception)
        {
            System.out.println ("Impossible de lire l'objet : " + exception.getMessage());
        }
        catch (IOException exception)
        {
            System.out.println ("Erreur lors de l'écriture : " + exception.getMessage());
        }
        return null;
    }

    public static void main(String[] args) {
        Person p = new Person("henry", "yohann");
        System.out.println(p.getFirstname() + p.getLastname());
        saveObject(p);
        Person q = loadObject();
        System.out.println(q.getFirstname() + q.getLastname());

    }

}
