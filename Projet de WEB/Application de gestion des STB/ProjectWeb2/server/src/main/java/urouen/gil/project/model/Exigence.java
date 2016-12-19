package urouen.gil.project.model;

import javax.persistence.*;
import javax.xml.bind.annotation.*;
import java.io.Serializable;

/**
 * Class That represent Exigence entity.
 *
 * @author Zebouchi Mohammed & Nabil Belkhous
 */
@XmlRootElement
@XmlAccessorType(XmlAccessType.FIELD)
@Entity
public class Exigence implements Serializable {

    @Id
    @GeneratedValue
    @Column(nullable = false)
    @XmlTransient
    private int id;
    @XmlElement(name="Identifiant")
    private String identifiant;
    @XmlElement(name="Description")
    private String description;
    @XmlElement(name="Priorite")
    private int priorite;
    @XmlTransient
    @ManyToOne(cascade={CascadeType.PERSIST, CascadeType.MERGE, CascadeType.REFRESH})
    private Fonctionnalite fonctionnalite;

    public Exigence() {
    }

    public Exigence(String identifiant, String description, int priorite) {
        this.identifiant = identifiant;
        this.description = description;
        this.priorite = priorite;
    }

    public Exigence(String identifiant, String description, int priorite, Fonctionnalite fonctionnalite) {
        this.identifiant = identifiant;
        this.description = description;
        this.priorite = priorite;
        this.fonctionnalite = fonctionnalite;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getIdentifiant() {
        return identifiant;
    }

    public void setIdentifiant(String identifiant) {
        this.identifiant = identifiant;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public int getPriorite() {
        return priorite;
    }

    public void setPriorite(int priorite) {
        this.priorite = priorite;
    }

    public Fonctionnalite getFonctionnalite() {
        return fonctionnalite;
    }

    public void setFonctionnalite(Fonctionnalite fonctionnalite) {
        this.fonctionnalite = fonctionnalite;
    }
}
