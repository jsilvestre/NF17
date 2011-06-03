/*
	Ce fichier permet de créer le schéma de la base de données (en prenant soin de supprimer l'ancien pour les éventuelles modifications)
*/
USE `NF17`;

FLUSH TABLES /* évite certains bugs à la création du schéma */

DROP TABLE IF EXISTS rendezVous;
DROP TABLE IF EXISTS adresse;
DROP TABLE IF EXISTS organisation;
DROP TABLE IF EXISTS contact;
DROP TABLE IF EXISTS utilisateur;

CREATE TABLE utilisateur (
	numSS integer(15),
	login varchar(25) UNIQUE NOT NULL,
	nom varchar(25),
	prenom varchar(25),
	dateNaissance date,
	mdp varchar(255),
	is_special boolean, /* true si l'utilisateur est spécial, false sinon */
	
	primary key(numSS)	
);

CREATE TABLE contact (
	numSS integer(15),
	nom varchar(25),
	prenom varchar(25),
	dateNaissance date,
	organisation varchar(50),
	poste varchar(35),
	
	primary key(numSS),
	foreign key(organisation) references organisation(nom)
);

CREATE TABLE organisation (
	nom varchar(50) primary key
);

CREATE TABLE adresse (
	pkArtif serial,
	numero integer(2),
	nom_rue varchar(35),
	cp integer(5),
	ville varchar(35),
	organisation varchar(50),
	
	primary key(pkArtif),
	foreign key(organisation) references organisation(nom)	
);

CREATE TABLE rendezVous (
	date_heure datetime,
	utilisateur integer(15),
	contact integer(15),
	annulation boolean,
	lieu integer,
	
	primary key(date_heure, utilisateur, contact, lieu), /* changement par rapport à eux : pour prendre en compte la correction du prof (contradictoire à deux endroits donc j'ai fait un choix)*/
	foreign key(utilisateur) references utilisateur(numSS),
	foreign key(contact) references contact(numSS),
	foreign key(lieu) references adresse(pkArtif)
);