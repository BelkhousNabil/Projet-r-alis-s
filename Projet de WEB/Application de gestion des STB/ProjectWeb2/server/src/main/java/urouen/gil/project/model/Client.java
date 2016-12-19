package urouen.gil.project.model;

import javax.persistence.*;
import javax.xml.bind.annotation.*;
import java.io.Serializable;

/**
 * Class That represent Client entity.
 *
 * @author Zebouchi Mohammed & Nabil Belkhous
 */
@XmlRootElement
@XmlAccessorType(XmlAccessType.FIELD)
@Entity
public class Client implements Serializable {

    @Id
    @GeneratedValue
    @Column(nullable = false)
    @XmlTransient
    private int id;
    @XmlElement(name="Entite")
    private String entite;
    @XmlElement(name="Contact")
    private String contact;
    @XmlElement(name="CP")
    private int cp;
    @XmlTransient
    @ManyToOne(cascade={CascadeType.PERSIST, CascadeType.MERGE, CascadeType.REFRESH})
    private STB stb;

    public Client(){

    }

    public Client(String entite, String contact, int cp) {
        this.entite = entite;
        this.contact = contact;
        this.cp = cp;
    }

    public Client(String entite, String contact, int cp, STB stb) {
        this.entite = entite;
        this.contact = contact;
        this.cp = cp;
        this.stb = stb;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setEntite(String entite) {
        this.entite = entite;
    }

    public void setContact(String contact) {
        this.contact = contact;
    }

    public void setCp(int cp) {
        this.cp = cp;
    }

    public String getEntite() {
        return entite;
    }

    public String getContact() {
        return contact;
    }

    public int getCp() {
        return cp;
    }

    public STB getStb() {
        return stb;
    }

    public void setStb(STB stb) {
        this.stb = stb;
    }
}

