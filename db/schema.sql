/*
	Ce fichier permet de créer le schéma de la base de données (en prenant soin de supprimer l'ancien pour les éventuelles modifications)
*/
USE `NF17`;

FLUSH TABLES; /* évite certains bugs à la création du schéma */

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
	numero integer(2) NOT NULL,
	nom_rue varchar(35) NOT NULL,
	cp integer(5) NOT NULL,
	ville varchar(35) NOT NULL,
	organisation varchar(50) NOT NULL,
	
	primary key(pkArtif),
	foreign key(organisation) references organisation(nom),
	
	unique(numero,nom_rue,cp,ville,organisation)
);

CREATE TABLE rendezVous (
	pkArtif serial,
	date_heure datetime NOT NULL,
	utilisateur integer(15) NOT NULL,
	contact integer(15) NOT NULL,
	annulation boolean,
	lieu integer NOT NULL,
	commentaire text,
	
	primary key(pkArtif),
	unique(date_heure, utilisateur, contact, lieu), /* changement par rapport à eux : pour prendre en compte la correction du prof (contradictoire à deux endroits donc j'ai fait un choix)*/
	foreign key(utilisateur) references utilisateur(numSS),
	foreign key(contact) references contact(numSS),
	foreign key(lieu) references adresse(pkArtif)
);

/*
- faire une vue utilisateur
- faire une vue administrateur
*/
