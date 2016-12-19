/*
 * Copyright 2016 Guillaume Leroy, Axelle Boucher, Mohammed Zebouchi, Safae Mahmdi, 
 * Najwa Jmaa & Antoine Gilbert

 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at

 *     http://www.apache.org/licenses/LICENSE-2.0

 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
package urouen.gil.project.controller;

import com.sun.org.apache.xpath.internal.operations.Bool;
import org.hibernate.Criteria;
import org.hibernate.Session;
import org.hibernate.Transaction;
import org.hibernate.criterion.Projections;
import org.hibernate.criterion.Restrictions;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.SAXException;
import urouen.gil.project.config.HibernateUtil;
import urouen.gil.project.model.*;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.xpath.XPath;
import javax.xml.xpath.XPathConstants;
import javax.xml.xpath.XPathExpressionException;
import javax.xml.xpath.XPathFactory;
import java.io.ByteArrayInputStream;
import java.io.IOException;
import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;

/**
 * Class  of Services.
 *
 * @author Zebouchi Mohammed & Nabil Belkhous
 */
public class Service {

    private Session session = null;
    private String xpathTitle = "/stb/Titre";
    private String xpathVersion = "/stb/Version";
    private String xpathDate = "/stb/Date";
    private String xpathDescription = "/stb/Description";
    private String xpathCommentaire = "/stb/Commentaire";
    private String xpathClient = "/stb/Client";
    private String xpathClientEntite = "Entite";
    private String xpathClientContact = "Contact";
    private String xpathClientCP = "CP";
    private String xpathEquipe = "/stb/Equipe";
    private String xpathEquipeNom = "nom";
    private String xpathEquipePrenom = "prenom";
    private String xpathEquipeGender = "gender";
    private String xpathFoncionnalite = "/stb/Fonctionnalite";
    private String xpathFoncionnaliteDiscription = "Description";
    private String xpathFoncionnalitePriorite = "Priorite";
    private String xpathFoncionnaliteExigence = "Exigence";
    private String xpathFoncionnaliteExigenceIdentifiant = "Identifiant";
    private String xpathFoncionnaliteExigenceDescription = "Description";
    private String xpathFoncionnaliteExigencePriorite = "Priorite";

    public Service(){
        session = HibernateUtil.getSession();
    }

    public STB saveSTB(String xmlSTB){

        DocumentBuilderFactory builderFactory = DocumentBuilderFactory.newInstance();
        try {
            DocumentBuilder builder  = builderFactory.newDocumentBuilder();
            Document xmlDocument = builder.parse(new ByteArrayInputStream(xmlSTB.getBytes()));
            XPath xPath =  XPathFactory.newInstance().newXPath();

            // Creation de l'STB
            String title = xPath.compile(xpathTitle).evaluate(xmlDocument);
            String verstion = xPath.compile(xpathVersion).evaluate(xmlDocument);
            String date = xPath.compile(xpathDate).evaluate(xmlDocument);
            String description = xPath.compile(xpathDescription).evaluate(xmlDocument);
            String commentaire = xPath.compile(xpathCommentaire).evaluate(xmlDocument);
            STB stb = new STB(title, verstion, date, description, commentaire);

            // Creation de des clients
            List<Client> clients = new ArrayList<Client>();
            NodeList nodeList = (NodeList) xPath.compile(xpathClient).evaluate(xmlDocument, XPathConstants.NODESET);
            for(int i = 0; i < nodeList.getLength(); i++){
                Node nodeClient = (Node) nodeList.item(i);
                String entite = xPath.compile(xpathClientEntite).evaluate(nodeClient);
                String contact = xPath.compile(xpathClientContact).evaluate(nodeClient);
                String cp = xPath.compile(xpathClientCP).evaluate(nodeClient);
                clients.add(new Client(entite, contact, Integer.valueOf(cp), stb));
            }
            stb.setClients(clients);

            // Creation de des equipes
            List<Equipe> equipes = new ArrayList<Equipe>();
            nodeList = (NodeList) xPath.compile(xpathEquipe).evaluate(xmlDocument, XPathConstants.NODESET);
            for(int i = 0; i < nodeList.getLength(); i++){
                Node nodeEquipe = nodeList.item(i);
                String nom = xPath.compile(xpathEquipeNom).evaluate(nodeEquipe);
                String prenom = xPath.compile(xpathEquipePrenom).evaluate(nodeEquipe);
                Boolean gender = Boolean.valueOf(xPath.compile(xpathEquipeGender).evaluate(nodeEquipe));
                equipes.add(new Equipe(nom, prenom, gender, stb));
            }
            stb.setEquipes(equipes);

            // Creation de des fonctionnalités
            List<Fonctionnalite> fonctionnalites = new ArrayList<Fonctionnalite>();
            nodeList = (NodeList) xPath.compile(xpathFoncionnalite).evaluate(xmlDocument, XPathConstants.NODESET);
            for(int i = 0; i < nodeList.getLength(); i++){
                Node nodeFonctionnalite = nodeList.item(i);
                String discription = xPath.compile(xpathFoncionnaliteDiscription).evaluate(nodeFonctionnalite);
                String priorite = xPath.compile(xpathFoncionnalitePriorite).evaluate(nodeFonctionnalite);
                Fonctionnalite fonctionnalite = new Fonctionnalite(discription, Integer.valueOf(priorite), stb);
                // Creation de des exigences d'une fonctionnalité
                List<Exigence> exigences = new ArrayList<Exigence>();
                NodeList nodeListExigences = (NodeList) xPath.compile(xpathFoncionnaliteExigence).evaluate(nodeFonctionnalite, XPathConstants.NODESET);
                for(int j = 0; j < nodeListExigences.getLength(); j++){
                    Node nodeExigence = nodeListExigences.item(j);
                    String identifiant = xPath.compile(xpathFoncionnaliteExigenceIdentifiant).evaluate(nodeExigence);
                    String descriptionExigence = xPath.compile(xpathFoncionnaliteExigenceDescription).evaluate(nodeExigence);
                    String prioriteExigence = xPath.compile(xpathFoncionnaliteExigencePriorite).evaluate(nodeExigence);
                    exigences.add(new Exigence(identifiant, descriptionExigence, Integer.valueOf(prioriteExigence), fonctionnalite));
                }
                fonctionnalite.setExigences(exigences);
                fonctionnalites.add(fonctionnalite);
            }
            stb.setFonctionnalites(fonctionnalites);

            session = HibernateUtil.getSession();
            Transaction tx = session.beginTransaction();
            session.save(stb);
            tx.commit();
			session.close();
            return stb;

        } catch (ParserConfigurationException e) {
            e.printStackTrace();
            return null;
        } catch (SAXException e) {
            e.printStackTrace();
            return null;
        } catch (IOException e) {
            e.printStackTrace();
            return null;
        } catch (XPathExpressionException e) {
            e.printStackTrace();
            return null;
        }

    }

    public STB getSTB(int id){
		session = HibernateUtil.getSession();
        Transaction tx = session.beginTransaction();
        Criteria criteria = session.createCriteria(STB.class);
        criteria.add(Restrictions.eq("id", id));
        STB stb = (STB) criteria.uniqueResult();
        session.close();
        return stb;
    }

    public List<STB> getAllSTB(){
		session = HibernateUtil.getSession();
        Transaction tx = session.beginTransaction();
        Criteria criteria = session.createCriteria(STB.class);
        List<STB> listSTB = (List<STB>) criteria.list();
        session.close();
        return listSTB;
    }

    public int getSTBCount() {
        try{
			session = HibernateUtil.getSession();
            Criteria criteria = session.createCriteria(STB.class);
            int count =((Number)criteria.setProjection(Projections.rowCount()).uniqueResult()).intValue();
            session.close();
            return  count;
        }catch (Exception e){
            return 0;
        }
    }

}
