package urouen.gil.project.model;

import org.hibernate.annotations.LazyCollection;
import org.hibernate.annotations.LazyCollectionOption;

import javax.persistence.*;
import javax.xml.bind.annotation.*;
import java.io.Serializable;
import java.util.List;

/**
 * Class That represent STB entity.
 *
 * @author Zebouchi Mohammed & Nabil Belkhous
 */
@XmlRootElement
@XmlAccessorType(XmlAccessType.FIELD)
@Entity
public class STB implements Serializable {

    @Id
    @GeneratedValue
    @Column(nullable = false)
    @XmlTransient
    private int id;
    @XmlElement(name="Titre")
    private String titre;
    @XmlElement(name="Version")
    private String version;
    @XmlElement(name="Date")
    private String date;
    @XmlElement(name="Description")
    private String description;
    @XmlElement(name="Client")
    @OneToMany(mappedBy = "stb",cascade = {CascadeType.ALL})
    private List<Client> clients;
    @XmlElement(name="Equipe")
    @OneToMany(mappedBy = "stb",cascade = {CascadeType.ALL})
    private List<Equipe> equipes;
    @XmlElement(name="Fonctionnalite")
    @OneToMany(mappedBy = "stb",cascade = {CascadeType.ALL})
    private List<Fonctionnalite> fonctionnalites;
    @XmlElement(name="Commentaire")
    private String commentaire;

    public STB(){

    }
	
	
	public STB(String titre, String version, String date, String description, String commentaire) {
		super();
		this.titre = titre;
		this.version = version;
		this.date = date;
		this.description = description;
        this.commentaire = commentaire;
	}

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getTitre() {
		return titre;
	}
	public void setTitre(String titre) {
		this.titre = titre;
	}
	public String getVersion() {
		return version;
	}
	public void setVersion(String version) {
		this.version = version;
	}
	public String getDate() {
		return date;
	}
	public void setDate(String date) {
		this.date = date;
	}
	public String getDescription() {
		return description;
	}
	public void setDescription(String description) {
		this.description = description;
	}

    public List<Client> getClients() {
        return clients;
    }

    public void setClients(List<Client> clients) {
        this.clients = clients;
    }

    public List<Equipe> getEquipes() {
        return equipes;
    }

    public void setEquipes(List<Equipe> equipes) {
        this.equipes = equipes;
    }

    public List<Fonctionnalite> getFonctionnalites() {
        return fonctionnalites;
    }

    public void setFonctionnalites(List<Fonctionnalite> fonctionnalites) {
        this.fonctionnalites = fonctionnalites;
    }

    public String getCommentaire() {
        return commentaire;
    }

    public void setCommentaire(String commentaire) {
        this.commentaire = commentaire;
    }
}
