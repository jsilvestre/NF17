/*
	Ce fichier permet de créer le schéma de la base de données (en prenant soin de supprimer l'ancien pour les éventuelles modifications)
*/
USE `NF17`;

/*DROP TABLE adresse;
DROP TABLE posteContact;
DROP TABLE administration;
DROP TABLE rendezVous;
DROP TABLE organisation;
DROP TABLE contact;
DROP TABLE utilisateur;*/

CREATE TABLE utilisateur (
	login varchar(25),
	numSS integer(15) UNIQUE NOT NULL,
	nom varchar(25),
	prenom varchar(25),
	dateNaissance date,
	mdp varchar(255),
	
	primary key(login)	
);

CREATE TABLE contact (
	identifiant varchar(25),
	numSS integer(15) UNIQUE NOT NULL,
	nom varchar(25),
	prenom varchar(25),
	dateNaissance date,
	
	primary key(identifiant)
);

CREATE TABLE organisation (
	nom varchar(50) primary key
);

CREATE TABLE adresse (
	id_adresse serial,
	nom_rue varchar(35),
	cp integer(5),
	ville varchar(35),
	organisation varchar(50),
	
	primary key(id_adresse),
	foreign key(organisation) references organisation(nom)	
);

CREATE TABLE rendezVous (
	date_heure datetime,
	utilisateur varchar(25),
	contact varchar(25),
	annulation boolean,
	lieu integer,
	
	primary key(date_heure, utilisateur, contact),
	foreign key(utilisateur) references utilisateur(login),
	foreign key(contact) references contact(identifiant),
	foreign key(lieu) references adresse(id_adresse)
);

CREATE TABLE administration (
	utilisateurspe varchar(255) primary key,

	foreign key(utilisateurspe) references utilisateur(login)
);

CREATE TABLE posteContact (
	salarie varchar(25),
	entreprise varchar(50),
	poste varchar(35),
	
	primary key(salarie,entreprise),
	foreign key(salarie) references contact(identifiant),
	foreign key(entreprise) references organisation(nom)
);