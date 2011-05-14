/*
	Ce fichier réalise les insertions dans la base de données pour réaliser les différents tests 
	(en prenant soin de supprimer les anciennes pour remettre à neuf la base)
*/
USE `nf17`;
DELETE  FROM posteContact;
DELETE  FROM administration;
DELETE  FROM rendezVous;
DELETE  FROM adresse;
DELETE  FROM organisation;
DELETE  FROM contact;
DELETE  FROM utilisateur;

/* insertion d'utilisateurs de tests */
INSERT INTO utilisateur(login,numSS,nom,prenom,dateNaissance,mdp) values('maximel',19002385,'Lefebvre','Maxime','1990-02-09','roucarnage');
INSERT INTO utilisateur(login,numSS,nom,prenom,dateNaissance,mdp) values('francoisg',1900238,'Guillepain','François','1988-08-15','pakhorabane');
INSERT INTO utilisateur(login,numSS,nom,prenom,dateNaissance,mdp) values('nathand',29002385,'Ducrey','Nathan','1990-06-20','getsubyakuya666ofdeathkillinginnocentmonkeys');

/* insertion des contacts */
INSERT INTO contact(identifiant,numSS,nom,prenom,dateNaissance) values('billt',1900238,'Tremendous','Bill','1978-04-25');
INSERT INTO contact(identifiant,numSS,nom,prenom,dateNaissance) values('hubertb',19002,'Bertier','Hubert','1982-12-01');
INSERT INTO contact(identifiant,numSS,nom,prenom,dateNaissance) values('ichigok',190023,'Kurosaki','Ichigo','1982-12-01');
INSERT INTO contact(identifiant,numSS,nom,prenom,dateNaissance) values('narutou',19002385,'Uzumaki','Naruto','1982-12-01');
INSERT INTO contact(identifiant,numSS,nom,prenom,dateNaissance) values('tryndalol',1900237,'LoL','Tryndamère','1982-12-01');
INSERT INTO contact(identifiant,numSS,nom,prenom,dateNaissance) values('garenlol',1900234,'LoL','Garen','1982-12-01');
INSERT INTO contact(identifiant,numSS,nom,prenom,dateNaissance) values('stephanec',190,'Crozat','Stéphane','1922-12-01');

/* organisation */
INSERT INTO organisation(nom) values('Université Technologique de Compiègne');
INSERT INTO organisation(nom) values('Club Dorothée');
INSERT INTO organisation(nom) values('Entreprise des héros OP de LoL');

/* insertion des adresses */
INSERT INTO adresse(numero,nom_rue,cp,ville,organisation) values(1,'roger coutolenc',60200,'Compiègne','Université Technologique de Compiègne');
INSERT INTO adresse(numero,nom_rue,cp,ville,organisation) values(2,'dessin animés',95000,'Paris','Club Dorothée');
INSERT INTO adresse(numero,nom_rue,cp,ville,organisation) values(3,'riot games',48100,'WTF','Entreprise des héros OP de LoL');

/* insertion des rendez-vous */
INSERT INTO rendezVous(date_heure,utilisateur,contact,annulation,lieu) values('2011-05-30 12:30:00','francoisg','tryndalol',false,3);
INSERT INTO rendezVous(date_heure,utilisateur,contact,annulation,lieu) values('2012-08-04 10:00:00','nathand','ichigok',false,2);
INSERT INTO rendezVous(date_heure,utilisateur,contact,annulation,lieu) values('201-04-02 22:00:00','maximel','stephanec',false,1);

/* insertion des administrateurs */
INSERT INTO administration(utilisateurspe) VALUES('hubertb');
INSERT INTO administration(utilisateurspe) VALUES('billt');

/* insertion des postes des contacts */
INSERT INTO posteContact(salarie,entreprise,poste) VALUES('tryndalol','Entreprise des héros OP de LoL','Président');
INSERT INTO posteContact(salarie,entreprise,poste) VALUES('garenlol','Entreprise des héros OP de LoL','Premier secrétaire');
INSERT INTO posteContact(salarie,entreprise,poste) VALUES('narutou','Club Dorothée','Animateur blond');
INSERT INTO posteContact(salarie,entreprise,poste) VALUES('stephanec','Université Technologique de Compiègne','Dieu');