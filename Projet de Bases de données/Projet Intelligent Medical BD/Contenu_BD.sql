1. Creation des table

	//table patient
	create table patient(id_patient number(10),id_caracteristique number(10),id_symptome number(10),nom_patient varchar(50),prenom_patient varchar(50),date_N_patient varchar(12),
	constraint pk_patient primary key(id_patient,id_caracteristique,id_symptome)
	);
	
	//table symptome
	create table symptome(id_symptome number(10),desc_symptomes varchar(300),
	constraint pk_sympt primary key(id_symptome)
	);

	//table caracteristique patient
	create table caract_patient(id_caract number(10),description varchar(300),
	constraint pk_caract_pat primary key(id_caract)
	);
	
	//table maladie
	create table maladie(id_maladie number(10),nom_maladie varchar(50),description varchar(300),type_maladie number(10),
	constraint pk_maladie primary key (id_maladie)
	);
	
	//table medecin
	create table medecin( id_medecin number(10),nom_medecin varchar(50), prenom_medecin varchar(50), date_N_med varchar(12),id_laboratoire number(10),
	constraint pk_med primary key (id_medecin),
	constraint fk_med foreign key(id_laboratoire) references laboratoire(id_laboratoire) on delete cascade 
	);
	
	//table consultation
	create table consultation ( id_consult number(10),id_trait number(10),id_patient number(10),id_medecin number(10),
	constraint pk_consult primary key (id_consult), 
	constraint fk1_consult foreign key (id_medecin) references medecin(id_medecin) on delete cascade
	);
	/*constraint fk2_consult foreign key (id_patient) references patient(id_patient) on delete cascade*/

	//table laboratoire
	create table laboratoire( id_laboratoire number(10),nom_lab varchar(300),
	constraint pk_lab primary key (id_laboratoire)
	);
	
	//table produit (production de medicament par un laboratoire mais par plusieurs medecins)
	create table produit( id_medicament number(10), id_medecin number(10), id_lab number(10), date_fabri varchar(12),
	constraint pk_prod primary key (id_medicament,id_medecin),
	constraint fk_prod foreign key (id_lab) references laboratoire(id_laboratoire) on delete cascade 
	);
	
	//table traitement
	create table traitement ( id_trait number(10),id_maladie number(10),id_medicament number(10), id_recommend number(10),duree number(4),type_tr number(10),
	constraint pk_trait primary key(id_trait,id_maladie,id_medicament,id_recommend)
	);

	//table medicament
	create table medicament( id_medicament number(10), nom_medic varchar(300), id_lab number(10), id_not number(10),droit_med varchar(3), droit_lab varchar(3),
	constraint pk_medicament primary key (id_medicament),
	constraint fk1_medicament foreign key (id_lab) references laboratoire(id_laboratoire) on delete cascade
	);
	
	//table notice
	create table notice( id_notice number(10), id_sub_active number(10),id_effect_indesir number(10),id_contre_indica number(10),id_indication number(10),
	constraint pk_notice primary key(id_notice,id_sub_active,id_effect_indesir,id_contre_indica,id_indication)
	);
	
	//table recommendation
	create table recommendation ( id_recommend number(10), description varchar(300),
	constraint pk_recommend primary key(id_recommend)
	);
	
	//table intercation_medicament
	create table intercation_medicament ( id_interaction number(10),id_medic1 number(10),id_medic2 number(10), description varchar(300),
	constraint pk_inter_medi primary key (id_interaction),
	constraint fk_inter_medi1 foreign key (id_medic1) references medicament(id_medicament) on delete cascade ,
	constraint fk_inter_medi2 foreign key (id_medic2) references medicament(id_medicament) on delete cascade 
	);
	
	//table substance active
	create table substance_active( id_sub_active number(10),description varchar(300), type_subst number(10),
	constraint pk_sub primary key (id_sub_active)
	);
	
	//table effect indesirable
	create table effect_indesirable( id_effet_indes number(10), description varchar(300),
	constraint pk_eff_indes primary key (id_effet_indes)
	);
	
	//table contre indication
	create table contre_indic( id_contre_ind number(10),description varchar(300),
	constraint pk_contre_ind primary key (id_contre_ind)
	);
	
	//table indication
	create table indication( id_indication number(10),description varchar(300),
	constraint pk_ind primary key (id_indication)
	);
	
	// table surveillance
	create table surveillance (id_surveillance number(10,2), id_consult number(10) ,rapport number(10),
	constraint pk_sur primary key (id_surveillance));
	
/*************************************************************************************************************************************************/
/* Insertion dans la table maladie*/
insert into maladie values(1,'Maladie de l appareil digestif','les maladies qui touche l appareil digestif',0); 
insert into maladie values(11,'Maladie de l estomac','les maladies qui touchent l estomac',1); 
insert into maladie values(12,'Maladies du foie','Les maladies qui touchent le foie',1); 
insert into maladie values(13,'Maladies du colon','Les maladie qui touche le colon',1); 

/* Insertion des maladie en relation avec l'estomat*/
insert into maladie values(111,'Gastrite','Les gastrites',11);
insert into maladie values(112,'Ulsaire','Les ulsaires',11);


/* Insertion des maladie en relation avec le foie*/
insert into maladie values(121,'cirrhose du foie','cirrhose du foie',12);
insert into maladie values(122,'Hepatite','Les Hepatites',12);
insert into maladie values(123,'Tuberculose hepatique','Tuberculose hepatique',12);


/* Insertion des maladie en relation avec le colon*/
insert into maladie values(131,'Crhon','Crhon',13);
insert into maladie values(132,'Colon héritable','Colon héritable',13);
	
/* Insertion des maladie en relation avec l'hepatite */
insert into maladie values(1221,'Hepatite alcoolique','Les Hepatites',122);
insert into maladie values(1222,'Hepatite chronique','Les Hepatites',122);
insert into maladie values(1223,'Hepatite virales humaines','Les Hepatites',122);
	
/* Insertion des hepatites virales humaines*/
insert into maladie values(12231,'Hepatite A','Les Hepatites',1223);
insert into maladie values(12232,'Hepatite B','Les Hepatites',1223);
insert into maladie values(12233,'Hepatite C','Les Hepatites',1223);
	
/* Insertion des symptomes */

insert into symptome values(1 ,'Douleurs abdominales');		
insert into symptome values(2 ,'Brûlures d estomac');	
insert into symptome values(3 ,'Nausées');	
insert into symptome values(4,'Perte d appétit');	
insert into symptome values(5 ,'Difficultés à digére');	
insert into symptome values(6 ,'Gêne sous les côtes');	
insert into symptome values(7 ,'Reflux gastro-oeusophagien');	
insert into symptome values(8 ,'Léger ictère des conjonctives');	
insert into symptome values(9 ,'Hypertension de la veine porte');	
insert into symptome values(10 ,'Fièvre');	
insert into symptome values(11 ,'Douleurs au niveau du foie');	
insert into symptome values(12 ,'Jaunissement');	
insert into symptome values(13 ,'Augmentation du volume du foie ');	
insert into symptome values(14 ,'Ictère');	
insert into symptome values(15 ,'Fatigue');	
insert into symptome values(16 ,'Perte de poids');	
insert into symptome values(17 ,'Vomissements');	
insert into symptome values(18 ,'Urine foncée');	
insert into symptome values(19 ,'Douleurs articulaires');	
insert into symptome values(20,'syndrome pseudo-grippal');	
insert into symptome values(21,'érythrose palmaire');	

/* Ajout de caracteristique */
insert into caract_patient values(1 ,'Jeune');
insert into caract_patient values(2 ,'vieux');
insert into caract_patient values(3 ,'sportif');
insert into caract_patient values(4 ,'Fragil');

/*  Ajout de patient*/
// patient atteint de gastrite
insert into patient values(1 ,3 ,1 ,'Marc','Alex','09/09/1988');
insert into patient values(1 ,3 ,2 ,'Marc','Alex','09/09/1988');
insert into patient values(1 ,3 ,3 ,'Marc','Alex','09/09/1988');
insert into patient values(1 ,3 ,4 ,'Marc','Alex','09/09/1988');
insert into patient values(1 ,3 ,5 ,'Marc','Alex','09/09/1988');

// patient atteint d ulcère
insert into patient values(2 ,4 ,1 ,'Alice','Merise','18/01/1978');
insert into patient values(2 ,4 ,6 ,'Alice','Merise','18/01/1978');
insert into patient values(2 ,4 ,7 ,'Alice','Merise','18/01/1978');

// patient atteint de cirrhose
insert into patient values(3 ,2 ,8 ,'Martine','Giles','18/01/1958');
insert into patient values(3 ,2 ,9 ,'Martine','Giles','18/01/1958');
insert into patient values(3 ,2 ,21 ,'Martine','Giles','18/01/1958');

// patient atteint d hepatite alcoolique
insert into patient values(7 ,4 ,10 ,'Claude','simon','22/11/1966');
insert into patient values(7 ,4 ,11 ,'Claude','simon','22/11/1966');
insert into patient values(7 ,4 ,12 ,'Claude','simon','22/11/1966');
insert into patient values(7 ,4 ,13 ,'Claude','simon','22/11/1966');

// patient dhepatite A
insert into patient values(4 ,1 ,3 ,'julien','beneto','01/01/1986');
insert into patient values(4 ,1 ,10 ,'julien','beneto','01/01/1986');
insert into patient values(4 ,1 ,14 ,'julien','beneto','01/01/1986');
insert into patient values(4 ,1 ,15 ,'julien','beneto','01/01/1986');
insert into patient values(4 ,1 ,16 ,'julien','beneto','01/01/1986');
insert into patient values(4 ,1 ,17 ,'julien','beneto','01/01/1986');

// patient hepatite B
insert into patient values(5 ,1 ,1 ,'laura','thibo','23/12/1990');
insert into patient values(5 ,1 ,18 ,'laura','thibo','23/12/1990');
insert into patient values(5 ,1 ,15 ,'laura','thibo','23/12/1990');
insert into patient values(5 ,1 ,16 ,'laura','thibo','23/12/1990');
insert into patient values(5 ,1 ,19 ,'laura','thibo','23/12/1990');
insert into patient values(5 ,1 ,3 ,'laura','thibo','23/12/1990');
insert into patient values(5 ,1 ,12 ,'laura','thibo','23/12/1990');
insert into patient values(5 ,1 ,17 ,'laura','thibo','23/12/1990');

// patient hepatite C
insert into patient values(6 ,3 ,3 ,'Paul','Milou','17/10/1980');
insert into patient values(6 ,3 ,10 ,'Paul','Milou','17/10/1980');
insert into patient values(6 ,3 ,17 ,'Paul','Milou','17/10/1980');
insert into patient values(6 ,3 ,15 ,'Paul','Milou','17/10/1980');
insert into patient values(6 ,3 ,20 ,'Paul','Milou','17/10/1980');

/* Insertion des consultation */
insert into consultation values(1 ,1 ,1 ,3 );
insert into consultation values(2 ,2 ,2 ,6 );
insert into consultation values(3 ,3 ,3 ,8 );
insert into consultation values(4 ,4 ,4 ,1 );
insert into consultation values(5 ,5 ,5 ,1 );
insert into consultation values(6 ,6 ,6 ,6 );
insert into consultation values(7 ,7 ,7 ,10 );
insert into consultation values(8 ,6 ,6 ,7 );

/* Insertion des laboratoires */
insert into laboratoire values(1 ,'3M SANTE');		
insert into laboratoire values(2 ,'ABBOTT France');	
insert into laboratoire values(3 ,'GROUPE ACTELION LTD');	
insert into laboratoire values(4,'GROUPE ASEPTA LABORATOIRES, MONACO');	
insert into laboratoire values(5 ,'ADP LABORATOIRE PHARMACEUTIQUE ');	
insert into laboratoire values(6 ,'AELSLIFE ');	
insert into laboratoire values(7 ,'GROUPE AGUETTANT SANTÉ, FRANCE ');	
insert into laboratoire values(8 ,'ALLERGAN France SAS ');	
insert into laboratoire values(9 ,'ALLOGA France');	
insert into laboratoire values(10 ,'GROUPE AMGEN, USA ');

/* Insertion des medecins */

insert into medecin values(1 ,'ALLON ','LEVY','12/09/1970',1);
insert into medecin values(2 ,'BACARD','HUGO','12/07/1971',2);
insert into medecin values(3 ,'BAKER ','MATTHEW','12/11/1972',6);
insert into medecin values(4 ,'BALWE','CHETAN','12/10/1973',8);
insert into medecin values(5 ,'BELAIR','LUC','12/11/1974',NULL);
insert into medecin values(6 ,'CEBALLOS','CESAR','12/12/1975',NULL);
insert into medecin values(7 ,'CHRISTIE','AARON','19/01/1961',2);
insert into medecin values(8 ,'FANTINI','ARNO','19/08/1967',2);
insert into medecin values(9 ,'GARAY-LOPEZ ','LUIS','19/09/1968',7);
insert into medecin values(10 ,'GILES','FLORES','19/07/1980',7);
insert into medecin values(11 ,'ERIKSSON ','DENNIS','19/01/1955',7);

/* Insertion de produit */

insert into produit values(1 ,7 ,2 ,'28/10/2012');
insert into produit values(1 ,8 ,2 ,'28/10/2012');

insert into produit values(2 ,2 ,2 ,'13/01/1999');

insert into produit values(3 ,9 ,7 ,'02/09/2010');
insert into produit values(3 ,10 ,7 ,'02/09/2010');
insert into produit values(3 ,11 ,7 ,'02/09/2010');

insert into produit values(4 ,1 ,1 ,'09/01/2009');

insert into produit values(5 ,11 ,7 ,'09/09/2009');

insert into produit values(6 ,3 ,6 ,'17/11/1993');

insert into produit values(7 ,2 ,2 ,'22/12/2002');

insert into produit values(8 ,1 ,2 ,'22/01/2014');

insert into produit values(9 ,10 ,7 ,'09/01/2009');

/* Insertion medicament */
insert into medicament values(1 ,'AMOXICILLINE / ACIDE CLAVULANIQUE MYLAN 500 mg',1 , 1,'oui','oui');
insert into medicament values(2 ,'OMEPRAZOLE ABBOTT 10 mg, gélule gastro-résistante',2 , 2,'oui','non');

insert into medicament values(3 ,'CLARITHROMYCINE ABBOTT 250 mg, comprimé pelliculé',3 , 3,'non','non');
insert into medicament values(4 ,'ALDACTONE 50 mg, comprimé sécable',4 , 4,'oui','oui');
insert into medicament values(5 ,'CORTANCYL 20 mg, comprimé sécable',5 , 5,'non','oui');
insert into medicament values(6 ,'CELESTENE 4 mg/1 ml, solution injectable',6 , 6,'non','non');
insert into medicament values(7 ,'HAVRIX 1440',7 , 7,'non','oui');
insert into medicament values(8 ,'BARACLUDE 0,05 mg/ml',8 , 8,'non','non');
insert into medicament values(9 ,'SOVALDI 400 mg, comprimé pelliculé',9 , 9,'oui','oui');


insert into intercation_medicament values(1 ,9 ,1 ,'Interaction, ces medicament peuvent avoir des effets negatifs ensemble');
insert into intercation_medicament values(2 ,2 ,8 ,'Ces deux medicament ne sont pas compatible');
insert into intercation_medicament values(3 ,7 ,3 ,'Ensemble ces deus medicament sont dangereux');

/* Insertion notice */

insert into notice values(1 ,1 ,1 ,1 ,1 );
insert into notice values(1 ,2 ,1 ,2 ,1 );

insert into notice values(2 ,3 ,2 ,3 ,2 );

insert into notice values(3 ,4 ,3 ,4 ,3 );

insert into notice values(4 ,5 ,4 ,5 ,4 );

insert into notice values(5 ,6 ,5 ,6 ,5 );

insert into notice values(6 ,7 ,6 ,7 ,6 );

insert into notice values(7 ,8 ,7 ,8 ,7 );

insert into notice values(8 ,9 ,8 ,9 ,8 );

insert into notice values(9 ,10 ,8 ,9 ,9);

/* Insertion substance active */
insert into substance_active values(1 ,'amoxicilline trihydratée',null);
insert into substance_active values(2 ,'clavulanate de potassium',null);

insert into substance_active values(3 ,'Oméprazole',null);

insert into substance_active values(4 ,'Clarithromycine',null);

insert into substance_active values(5 ,'Spironolactone micronisée',null);

insert into substance_active values(6 ,'Prednisone',null);

insert into substance_active values(7 ,'Phosphate disodique de bétaméthasone',null);

insert into substance_active values(8 ,' produit sur cellules diploïdes humaines (MRC-5)',null);

insert into substance_active values(9 ,'Entecavir',null);

insert into substance_active values(10 ,'sofosbuvir',null);

/* Insertion effect indesirable */
insert into effect_indesirable values(1 ,'nausées, vomissements, Allergies');

insert into effect_indesirable values(2 ,'Apparition soudaine d’une respiration sifflante, Maux de tête');

insert into effect_indesirable values(3 ,'allongement de lintervalle QT,  dépression, vertiges, trouble du goût, perte de lodorat');

insert into effect_indesirable values(4 ,'Troubles digestifs, Eruption cutanée, Insuffisance rénale aiguë');

insert into effect_indesirable values(5 ,' modification de certains paramètres biologiques,  apparition de bleus, fragilité osseuse: ostéoporose, fracture');

insert into effect_indesirable values(6 ,'gonflement et rougeur du visage, prise de poids');

insert into effect_indesirable values(7 ,'Irritabilité, Maux de tête, Douleur et rougeur au point d’injection');

insert into effect_indesirable values(8 ,'Syndrome hépato-rénal');

 id_effet_indes,cause , description 
 
/* Insertion contre indication */ 
insert into contre_indic values(1 ,'Ne pas prendre si vous avez: allergie aux antibiotiques de la famille des bêta-lactamines');
insert into contre_indic values(2 ,'Ne pas prendre si vous avez: antécédent d atteinte hépatique liée à l association amoxicilline/acide clavulanique');
 
insert into contre_indic values(3 ,'Ne pas prendre si vous avez: vous êtes allergique (hypersensible)');

insert into contre_indic values(4 ,'Provoque des allergies aux antibiotiques de la famille des macrolides');

insert into contre_indic values(5 ,'Ne pas prendre si vous avez:  insuffisance rénale, hyperkaliémie');

insert into contre_indic values(6 ,'Ne pas prendre si vous avez certaines maladies virales en évolution (hépatites virales, herpès, varicelle, zona)');
 
insert into contre_indic values(7 ,'Ne pas prendre si vous avez: une infection, certains troubles mentaux non traités');

insert into contre_indic values(8 ,'Ne pas prendre si vous avez une allergie connue à l un des composants du vaccin,  Infections fébriles sévères');

insert into contre_indic values(9 ,'Ne pas prendre si vous avez: une Hypersensibilité à la substance active');

/* Insertion indication */ 
insert into indication values(1 ,'Ce médicament est indiqué dans le traitement des infections dues aux germes sensibles');

insert into indication values(2 ,'Pour reflux gastro-oeusophagien, et ulcères de la partie haute de votre intestin');

insert into indication values(3 ,'Ce médicament est indiqué chez l adulte dans le traitement de certaines infections bactériennes à germes sensibles');

insert into indication values(4 ,'Ce médicament est indiqué dans le traitement de l hypertension artérielle, le traitement des oeudèmes');

insert into indication values(5 ,'Il est indiqué dans certaines maladies, où il est utilisé pour son effet anti-inflammatoire');

insert into indication values(6 ,'Il peut être utilisé en injection locale, en dermatologie, en ophtalmologie, en ORL et en rhumatologie');

insert into indication values(7 ,'Ce médicament est préconisé dans la prévention de l’infection provoquée par le virus de l’hépatite A');

insert into indication values(8 ,'Baraclude est indiqué dans le traitement des patients adultes atteints d une infection chronique par levirus de l hépatite B (VHB)');

insert into indication values(9 ,'Sovaldi est indiqué, en association avec d’autres médicaments, pour le traitement de l’hépatite C ');

/* insertion de recommendation et traitement pour chaque maladie */

// pr gastrite
insert into recommendation values (1 , 'Adopter un régime alimentaire riche en fibres, Avoir une alimentation riche en antioxydants, Boire 6-8 verres d eau par jour afin d’éviter la déshydratation, Faites de l exercice au moins 30 minutes par jour, 5 jours par semaine');

insert into traitement values(1 ,111 ,1 ,1 ,3 ,1 ); // traitement normal 1, chronique 2
insert into traitement values(1 ,111 ,2 ,1 ,3 ,1 );
insert into traitement values(1 ,111 ,3 ,1 ,3 ,1 );

// pr ulsaire
insert into recommendation values (2 , 'Fractionnnez vos repas tout au long de la journée (3 à 4 par jour), Evitez les périodes de jeûne prolongées, Arrêtez ou tout au moins réduisez votre consommation de tabac');

insert into traitement values(2 ,112 ,1 ,2 ,6 ,1 ); // traitement normal 1, chronique 2
insert into traitement values(2 ,112 ,2 ,2 ,6 ,1 );
insert into traitement values(2 ,112 ,3 ,2 ,6 ,1 );


// pr cirrhose
insert into recommendation values (3 , 'Ne plus boire d alcoole, eviter le surpoid et le diabète, Effectuer une ponction évacuatrice cher un spécialiste');

insert into traitement values(3 ,121 ,4 ,3 ,24 ,2 );

// pr Hepatite alcoolique
insert into recommendation values (4 , 'Ne plus boire d alcoole, Eviter les activités intenses, être à cheval sur le traitement, faire attention à ne pas contaminer l entourage');

insert into traitement values(4 ,1221 ,5 ,4 ,24 ,2 );

// pr Hepatite A
insert into recommendation values (5 , 'Beaucoup de repos, Faire une diète, eviter de contaminer l entourage');

insert into traitement values(5 ,12231 ,7 ,5 ,3 ,1 );

// pr Hepatite B et C 
insert into recommendation values (6 , 'Beaucoup de repos, Poursuivre une stratégie de dépistage ciblé des infections virales B et C en fonction des facteurs de risque de contamination, La vaccination contre le VHB est efficace et sûre');

insert into traitement values(6 ,12232 ,8 ,6 ,24 ,2 );

insert into traitement values(7 ,12233 ,9 ,6 ,24 ,2 );


/* Insertion interaction medicamenteuse */

insert into intercation_medicament values(1 ,1 ,5 ,'Dangereux');
insert into intercation_medicament values(2 ,2 ,8 ,'Dangereux');
insert into intercation_medicament values(3 ,3 ,9 ,'Dangereux');
insert into intercation_medicament values(4 ,4 ,5 ,'Dangereux');
