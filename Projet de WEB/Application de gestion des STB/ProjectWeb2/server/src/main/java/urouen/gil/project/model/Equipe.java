package urouen.gil.project.model;

import javax.persistence.*;
import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlRootElement;
import javax.xml.bind.annotation.XmlTransient;
import java.io.Serializable;

/**
 * Class That represent Equipe entity.
 *
 * @author Zebouchi Mohammed & Nabil Belkhous
 */
@XmlRootElement
@XmlAccessorType(XmlAccessType.FIELD)
@Entity
public class Equipe implements Serializable {

    @Id
    @GeneratedValue
    @Column(nullable = false)
    @XmlTransient
    private int id;
    private String nom;
    private String prenom;
    private Boolean gender;
    @XmlTransient
    @ManyToOne(cascade={CascadeType.PERSIST, CascadeType.MERGE, CascadeType.REFRESH})
    private STB stb;

    public Equipe() {
    }

    public Equipe(String nom, String prenom, Boolean gender) {
        this.nom = nom;
        this.prenom = prenom;
        this.gender = gender;
    }

    public Equipe(String nom, String prenom, Boolean gender, STB stb) {
        this.nom = nom;
        this.prenom = prenom;
        this.gender = gender;
        this.stb = stb;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    public Boolean getGender() {
        return gender;
    }

    public void setGender(Boolean gender) {
        this.gender = gender;
    }

    public STB getStb() {
        return stb;
    }

    public void setStb(STB stb) {
        this.stb = stb;
    }
}
