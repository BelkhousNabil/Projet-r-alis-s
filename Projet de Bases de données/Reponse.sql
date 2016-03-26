1.

/* 
	- recuperer le dernier id de consultation id ++;
	- Inserer dans Consultation, id consultation, id patient, id traitement, id medecin
	- Si patient n'existe pas, on doit l'ajouter
	- si traitement n'existe pas on doit l'ajouter
*/

CREATE OR REPLACE PROCEDURE prescription (id_pat NUMBER, id_trait NUMBER, id_med NUMBER) is 
		id_cons NUMBER(10);
		nbPatient number(10);
		nbMedecin number(10);
	BEGIN
		select MAX(id_consult) into id_cons
		from consultation;
		
		id_cons:= id_cons+1;
		
		select count(*) into nbMedecin
		from medecin m
		where m.id_medecin = id_med;
		
		if(nbMedecin=0) then 
			raise_application_error(-20900,'Ce medecin n existe pas !');
			else 
				select count(*) into nbPatient
				from patient p
				where p.id_patient = id_pat;
				
				if(nbPatient=0) then 
					raise_application_error(-20901,'Ce patient n existe pas veulliez le créer');
					else 
						insert into consultation values(id_cons,id_trait,id_pat,id_med );
				end if;
		end if;
	END ;	
/

execute prescription(1,4,4);

select id_consult
from consultation;

2. 

create or replace type arraymedicamanet as table of varchar(300) ;
/

set serveroutput on ;

CREATE OR REPLACE function liste_Medicament (id_malad NUMBER) return arraymedicamanet as 
	arraymed arraymedicamanet := arraymedicamanet();
	 i integer :=0;
	 nom_med varchar(300);
	BEGIN
		
		for nom_medic1 in (select m.nom_medic
		from traitement t , medicament m
		where t.id_medicament = m.id_medicament and t.id_maladie = id_malad) loop 
			i := i+1;
			arraymed.extend;
			arraymed(i) := nom_medic1.nom_medic ; 
		end loop;

		return arraymed;
	END ;	
/

select liste_Medicament(111)
from dual;

select liste_Medicament(12232)
from dual;

3.

create or replace type arrayeffet as table of varchar(300) ;
/

CREATE OR REPLACE function liste_Effet (effet NUMBER) return arrayeffet as 
	arrayeffet_sec arrayeffet  := arrayeffet();
	 i integer :=0;
	 nom_med varchar(300);
	BEGIN
		
		for nom_eff in (select distinct e.description
							from effect_indesirable e , notice n , medicament m
							where m.id_not = n.id_notice and e.id_effet_indes = n.id_effect_indesir and m.id_medicament = effet) loop 
			i := i+1;
			arrayeffet_sec.extend;
			arrayeffet_sec(i) := nom_eff.description ; 
		end loop;

		return arrayeffet_sec;
	END ;	
/

select liste_Effet(1)
from dual;

4.
select m.nom_medic as Prescription_Medecin_Createur
from medicament m
where m.droit_med = 'oui';

5.
select m.nom_medic as Prescription_Medecin_Lab
from medicament m
where m.droit_lab = 'oui';

6.
/* recuperer les maladies à partir de symptomes */
select distinct m.nom_maladie as Maladie
from maladie m , consultation c , traitement t , patient p
where m.id_maladie = t.id_maladie and t.id_trait = c.id_trait and p.id_patient = c.id_patient and p.id_symptome = &symptome;

/* recuperer les maladies à partir de caracteristiques */
select distinct m.nom_maladie as Maladie
from maladie m , consultation c , traitement t , patient p
where m.id_maladie = t.id_maladie and t.id_trait = c.id_trait and p.id_patient = c.id_patient and p.id_caracteristique = &Caracteristique;

7.

/* requete toute seule*/
select count(t.id_medicament)
from consultation c , traitement t , produit p
where c.id_consult = &consultation and  c.id_trait = t.id_trait and t.id_medicament = p.id_medicament and 
		p.id_medecin = c.id_medecin ;
		

select count(t.id_medicament)
from consultation c , traitement t , produit p, medecin m
where c.id_consult = &consultation and c.id_trait = t.id_trait and t.id_medicament = p.id_medicament and 
		m.id_medecin != c.id_medecin and 
		p.id_lab = m.id_laboratoire ;
		
select count(*)
from consultation;
/* requete toute seule*/

CREATE OR REPLACE PROCEDURE rapport (consut NUMBER) is 
		nbm NUMBER(10);
		nbl number(10);
		nbt number(10);
		id number(10);
		res number(10,2);
	BEGIN
		select count(t.id_medicament) into nbm
		from consultation c , traitement t , produit p
		where c.id_consult = consut and  c.id_trait = t.id_trait and t.id_medicament = p.id_medicament and 
				p.id_medecin = c.id_medecin ;
		
		select count(t.id_medicament) into nbl
		from consultation c , traitement t , produit p, medecin m
		where c.id_consult = consut and c.id_trait = t.id_trait and t.id_medicament = p.id_medicament and 
				m.id_medecin != c.id_medecin and 
				p.id_lab = m.id_laboratoire ;
		
		select count(*) into nbt
		from consultation;
		
		select count(*) into id
		from surveillance;
		
		id:=id+1;
		
		if nbm+nbl = 0 then 
			insert into surveillance values(id ,consut ,0 );
			else 
				res:= nbt/(nbm+nbl);
				insert into surveillance values(id ,consut ,res );
		end if;
	END ;	
/

execute rapport(7);


8.

CREATE OR REPLACE PROCEDURE Verfier_traitement (id_pat number , traitement2 number) is 

	begin

		for tr in (select distinct m.id_medicament ,m.nom_medic , t.id_trait
		from traitement t , patient p , consultation c , medicament m
		where p.id_patient = c.id_patient and t.id_trait = c.id_trait and m.id_medicament = t.id_medicament and p.id_patient = id_pat)
		loop 
				for t in (select  m.id_medicament , i.id_medic1 , i.id_medic2
					from traitement t , medicament m , intercation_medicament i
					where  t.id_trait = traitement2 and m.id_medicament = t.id_medicament and (m.id_medicament = i.id_medic1 or m.id_medicament = i.id_medic2))
					loop
						if (t.id_medic2 = tr.id_medicament) or (t.id_medic1 = tr.id_medicament) then 

							DBMS_OUTPUT.PUT_LINE('Problème avec le traitement '|| tr.id_trait ||' et le traitement '||traitement2);
							DBMS_OUTPUT.PUT_LINE('Interaction entre le medicament '|| tr.id_medicament ||' et le medicament '||t.id_medic2);

						END IF;
						
					end loop;
		end loop;

	end;
/

execute Verfier_traitement(1 , 7);


9.
CREATE OR REPLACE PROCEDURE Ajout_Effect_Indesi (effet varchar) is 
		id_eff number(10);
		id_f number(10);
		
	BEGIN
		  
		select MAX(id_effet_indes) into id_eff
		from effect_indesirable;

		id_eff:= id_eff+1;
		
		select id_effet_indes into id_f
		from effect_indesirable e
		where e.description like CONCAT('%',CONCAT(effet,'%'));
		
		IF SQL%ROWCOUNT !=0 then
			raise_application_error(-20910,'Effet Indesirable existant!');

		END IF;
		
		EXCEPTION
			WHEN NO_DATA_FOUND THEN insert into effect_indesirable values(id_eff,effet);
			
	END ;	
/

execute Ajout_Effect_Indesi('Perturbation');

select * 
from effect_indesirable
where description = 'Perturbation';

 
10.
/* afficher l'arborécence d'une maladie */

	SELECT id_maladie , nom_maladie , level
	FROM maladie
	START WITH type_maladie = &Maladie
	CONNECT BY PRIOR id_maladie = type_maladie 
	ORDER BY LEVEL ASC , id_maladie ASC;
	
11.
/* Donner tout les medecin d'un laboratoire */

select m.nom_medecin as Medecin , l.id_laboratoire as Laboratoire
from medecin m , laboratoire l
where m.id_laboratoire = l.id_laboratoire and l.id_laboratoire = &laboratoire;

12. 
/* Liste des medecins et les medicament qu'il ont crées */
select m.nom_medecin as Medecin, me.nom_medic as Medicament
from medecin m, medicament me , produit p
where p.id_medecin = m.id_medecin and p.id_medicament = me.id_medicament
order by m.nom_medecin;

13.
/* Interaction entre les medicament */

select i.id_interaction as Interaction,i.id_medic1 as Medicament, i.id_medic2 as Medicament
from intercation_medicament i;