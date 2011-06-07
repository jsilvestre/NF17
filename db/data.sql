/*
	Ce fichier réalise les insertions dans la base de données pour réaliser les différents tests 
	(en prenant soin de supprimer les anciennes pour remettre à neuf la base)
*/
USE `nf17`;
DELETE FROM rendezVous;
DELETE FROM adresse;
DELETE FROM organisation;
DELETE FROM contact;
DELETE FROM utilisateur;

/* insertion d'utilisateurs de tests */
INSERT INTO utilisateur(numSS,login,nom,prenom,dateNaissance,mdp,is_special) values(19002385,'maximel','Lefebvre','Maxime','1990-02-09','roucarnage',false);
INSERT INTO utilisateur(numSS,login,nom,prenom,dateNaissance,mdp,is_special) values(19002384,'francoisg','Guillepain','François','1988-08-15','pakhorabane',true);
INSERT INTO utilisateur(numSS,login,nom,prenom,dateNaissance,mdp,is_special) values(29002383,'nathand','Ducrey','Nathan','1990-06-20','getsubyakuya666ofdeathkillinginnocentmonkeys',false);

/* insertion des contacts */
INSERT INTO contact(numSS,nom,prenom,dateNaissance,organisation,poste) values(1900238,'Tremendous','Bill','1978-04-25','Service Secret Americain','Agent double');
INSERT INTO contact(numSS,nom,prenom,dateNaissance,organisation,poste) values(1900236,'Bertier','Hubert','1982-12-01','Club Dorothée','Président du fan club');
INSERT INTO contact(numSS,nom,prenom,dateNaissance,organisation,poste) values(1900235,'Crozat','Stéphane','1922-12-01','Université Technologique de Compiègne','Dieu');
                                                           
/* organisation */
INSERT INTO organisation(nom) values('Université Technologique de Compiègne');
INSERT INTO organisation(nom) values('Club Dorothée');
INSERT INTO organisation(nom) values('Service Secret Americain');

/* insertion des adresses */
INSERT INTO adresse(pkArtif,numero,nom_rue,cp,ville,organisation) values(1,18,'roger coutolenc',60200,'Compiègne','Université Technologique de Compiègne');
INSERT INTO adresse(pkArtif,numero,nom_rue,cp,ville,organisation) values(2,2,'dessin animés',95000,'Paris','Club Dorothée');
INSERT INTO adresse(pkArtif,numero,nom_rue,cp,ville,organisation) values(3,2,'Roger Harrison',48100,'Washington','Service Secret Americain');

/* insertion des rendez-vous */
INSERT INTO rendezVous(date_heure,utilisateur,contact,annulation,lieu) values('2012-05-30 12:30:00',19002384,1900236,false,3);
INSERT INTO rendezVous(date_heure,utilisateur,contact,annulation,lieu) values('2012-08-04 10:00:00',29002383,1900238,false,2);
INSERT INTO rendezVous(date_heure,utilisateur,contact,annulation,lieu) values('2012-04-02 22:00:00',19002385,1900235,false,1);
INSERT INTO rendezVous(date_heure,utilisateur,contact,annulation,lieu) values('2013-04-02 22:00:00',19002385,1900235,false,1);