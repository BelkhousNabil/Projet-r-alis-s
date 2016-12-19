package urouen.gil.project.config;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.boot.MetadataSources;
import org.hibernate.boot.registry.StandardServiceRegistry;
import org.hibernate.boot.registry.StandardServiceRegistryBuilder;

import org.hibernate.cfg.Configuration;

/**
 * HibernateUtil - The class allow to create a hibernate session
 *
 * @author Anouar & Nabil
 * @version 1.0
 * @date 12/04/2016
 */
public class HibernateUtil {
    private static SessionFactory sessionFactory;
    private static final StandardServiceRegistry registry = new StandardServiceRegistryBuilder()
            .configure() // configures settings from hibernate.cfg.xml
            .build();
    static {
        try {
            sessionFactory = new MetadataSources( registry ).buildMetadata().buildSessionFactory();
        }
        catch (Exception e) {
            // The registry would be destroyed by the SessionFactory, but we had trouble building the SessionFactory
            // so destroy it manually.
            StandardServiceRegistryBuilder.destroy( registry );
        }
    }


    /**
     * getSession This function return a session of Hibarnate
     * @return Session
     */
    public static synchronized Session getSession() {
        return sessionFactory.openSession();
    }

}
