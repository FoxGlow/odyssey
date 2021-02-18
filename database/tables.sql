CREATE TABLE utilisateur(
id_utilisateur int PRIMARY KEY NOT NULL AUTO_INCREMENT,
nom VARCHAR (20), 
prenom VARCHAR (20), 
mail VARCHAR (50));

CREATE TABLE projet(
id_projet int PRIMARY KEY NOT NULL AUTO_INCREMENT, 
nom VARCHAR (20), 
description_projet VARCHAR (300) NOT NULL ,
ref_chef int not null ,
CONSTRAINT FK_PROJET_REF_CHEF FOREIGN KEY (ref_chef) REFERENCES utilisateur(id_utilisateur));


CREATE TABLE message(
id_message int PRIMARY KEY NOT NULL AUTO_INCREMENT,
texte VARCHAR (300),
date_ date ,
ref_utilisateur int NOT NULL ,
ref_projet int NOT NULL ,
CONSTRAINT FK_REF_UTILISATEUR FOREIGN KEY (ref_utilisateur) REFERENCES utilisateur(id_utilisateur),  
CONSTRAINT FK_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE notification(
id_notification int PRIMARY KEY NOT NULL AUTO_INCREMENT,
texte VARCHAR (300),
date_ date ,
ref_utilisateur int NOT NULL ,
ref_projet int NOT NULL ,
CONSTRAINT FK_NOTIFICATION_REF_UTILISATEUR FOREIGN KEY (ref_utilisateur) REFERENCES utilisateur(id_utilisateur),  
CONSTRAINT FK_NOTIFICATION_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE associe (
    ref_utilisateur int NOT NULL AUTO_INCREMENT,
    ref_projet int NOT NULL,
    CONSTRAINT PK_ASSOCIE PRIMARY KEY (ref_utilisateur , ref_projet),
    CONSTRAINT FK_ASSOCIE_REF_UTILISATEUR FOREIGN KEY (ref_utilisateur)
        REFERENCES utilisateur (id_utilisateur),
    CONSTRAINT FK_ASSOCIE_REF_PROJET FOREIGN KEY (ref_projet)
        REFERENCES projet (id_projet)
);

CREATE TABLE conseil(
id_conseil int PRIMARY KEY NOT NULL AUTO_INCREMENT, 
message VARCHAR (500) NOT NULL, 
ref_projet int NOT NULL,
CONSTRAINT FK_CONSEIL_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE mcd( 
id_mcd int NOT NULL PRIMARY KEY AUTO_INCREMENT,
fichier long,
ref_projet int NOT NULL,
CONSTRAINT FK_MCD_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE cvo( 
id_cvo int NOT NULL PRIMARY KEY AUTO_INCREMENT,
fichier long,
ref_projet int NOT NULL,
CONSTRAINT FK_CVO_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE bpmn( 
id_bpmn int NOT NULL PRIMARY KEY AUTO_INCREMENT,
fichier long,
ref_projet int NOT NULL,
CONSTRAINT FK_BPMN_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE story_map( 
id_story_map int NOT NULL PRIMARY KEY AUTO_INCREMENT,
fichier long,
ref_projet int NOT NULL,
CONSTRAINT FK_STORY_MAP_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE mcf( 
id_mcf int NOT NULL PRIMARY KEY AUTO_INCREMENT,
fichier long,
ref_projet int NOT NULL,
CONSTRAINT FK_MCF_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE piscine(
id_piscine int NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR (30) NOT NULL,
ref_bmpn int NOT NULL,
CONSTRAINT FK_PISCINE_REF_BPMN FOREIGN KEY (ref_bmpn) REFERENCES bpmn(id_bpmn));

CREATE TABLE user_story(
id_user_story int NOT NULL PRIMARY KEY AUTO_INCREMENT,
contenu VARCHAR (300) NOT NULL,
ref_st int NOT NULL,
CONSTRAINT FK_USER_STORY_REF_ST FOREIGN KEY (ref_st) REFERENCES story_map(id_story_map));

CREATE TABLE epic(
id_epic int NOT NULL PRIMARY KEY AUTO_INCREMENT,
evenement VARCHAR (300) NOT NULL,
ref_st int NOT NULL,
CONSTRAINT FK_EPIC_REF_ST FOREIGN KEY (ref_st) REFERENCES story_map(id_story_map));

CREATE TABLE acteur(
id_acteur int NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(30) NOT NULL,
interne boolean NOT NULL);

CREATE TABLE flux(
id_flux_mcf int NOT NULL PRIMARY KEY AUTO_INCREMENT,
message VARCHAR (500) NOT NULL,
ref_acteur_émetteur int NOT NULL,
ref_acteur_récepteur int NOT NULL,
ref_mcf int NOT NULL,
CONSTRAINT FK_FLUX_REF_ACTEUR_EMETTEUR FOREIGN KEY (ref_acteur_émetteur) REFERENCES acteur(id_acteur),
CONSTRAINT FK_FLUX_REF_ACTEUR_RECEPETEUR FOREIGN KEY (ref_acteur_récepteur) REFERENCES acteur(id_acteur),
CONSTRAINT FK_FLUX_REF_MCF FOREIGN KEY (ref_mcf) REFERENCES acteur(id_acteur));

CREATE TABLE couloir(
id_couloir int NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR (30) NOT NULL,
ref_piscine int NOT NULL,
CONSTRAINT FK_EPIC_REF_PISCINE FOREIGN KEY (ref_piscine) REFERENCES piscine(id_piscine));

CREATE TABLE flux_bpmn(
id_flux_bpmn int NOT NULL PRIMARY KEY AUTO_INCREMENT,
message VARCHAR (500) NOT NULL,
ref_couloir int NOT NULL,
CONSTRAINT FK_FLUX_BPMN_REF_COULOIR FOREIGN KEY (ref_couloir) REFERENCES couloir(id_couloir));

CREATE TABLE activite(
id_activite int NOT NULL PRIMARY KEY AUTO_INCREMENT,
type_activité VARCHAR (30) NOT NULL,
nom VARCHAR (30) NOT NULL,
est_sous_processus boolean not null,
ref_couloir int NOT NULL,
CONSTRAINT FK_ACTIVITE_REF_COULOIR FOREIGN KEY (ref_couloir) REFERENCES couloir(id_couloir));