package urouen.gil.project.model;


import org.hibernate.annotations.LazyCollection;
import org.hibernate.annotations.LazyCollectionOption;

import javax.persistence.*;
import javax.xml.bind.annotation.*;
import java.io.Serializable;
import java.util.List;

/**
 * Class That represent Exigence entity.
 *
 * @author Zebouchi Mohammed & Nabil Belkhous
 */
@XmlRootElement
@XmlAccessorType(XmlAccessType.FIELD)
@Entity
public class Fonctionnalite implements Serializable {

    @Id
    @GeneratedValue
    @Column(nullable = false)
    @XmlTransient
    private int id;
    @XmlElement(name="Description")
    private String  description;
    @XmlElement(name="Priorite")
    private int priorite;
    @XmlElement(name="Exigence")
    @OneToMany(mappedBy = "fonctionnalite",cascade = {CascadeType.ALL})
    private List<Exigence> exigences;
    @XmlTransient
    @ManyToOne(cascade={CascadeType.PERSIST, CascadeType.MERGE, CascadeType.REFRESH})
    private STB stb;

    public Fonctionnalite() {
    }

    public Fonctionnalite(String description, int priorite) {
        this.description = description;
        this.priorite = priorite;
    }

    public Fonctionnalite(String description, int priorite, STB stb) {
        this.description = description;
        this.priorite = priorite;
        this.stb = stb;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
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

    public List<Exigence> getExigences() {
        return exigences;
    }

    public void setExigences(List<Exigence> exigences) {
        this.exigences = exigences;
    }

    public STB getStb() {
        return stb;
    }

    public void setStb(STB stb) {
        this.stb = stb;
    }
}
