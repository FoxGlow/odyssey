CREATE TABLE utilisateur(
id_utilisateur int PRIMARY KEY NOT NULL AUTO_INCREMENT,
nom VARCHAR (255), 
prenom VARCHAR (255), 
mail VARCHAR (255),
mot_de_passe VARCHAR(255) NOT NULL
UNIQUE KEY unique_email (mail)
);


CREATE TABLE projet(
id_projet int PRIMARY KEY NOT NULL AUTO_INCREMENT, 
nom VARCHAR (255), 
description VARCHAR(255) NOT NULL,
ref_chef int NOT NULL,
CONSTRAINT FK_PROJET_REF_CHEF FOREIGN KEY (ref_chef) REFERENCES utilisateur(id_utilisateur));


CREATE TABLE message(
id_message int PRIMARY KEY NOT NULL AUTO_INCREMENT,
texte VARCHAR (255),
date_ date,
ref_utilisateur int NOT NULL,
ref_projet int NOT NULL,
CONSTRAINT FK_REF_UTILISATEUR FOREIGN KEY (ref_utilisateur) REFERENCES utilisateur(id_utilisateur),  
CONSTRAINT FK_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

CREATE TABLE notification(
id_notification int PRIMARY KEY NOT NULL AUTO_INCREMENT,
texte VARCHAR (255),
date_ date,
ref_utilisateur int NOT NULL,
ref_projet int NOT NULL,
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
    ON DELETE CASCADE
);

CREATE TABLE feedback(
id_feedback int PRIMARY KEY NOT NULL AUTO_INCREMENT, 
message VARCHAR (255) NOT NULL, 
ref_projet int NOT NULL,
CONSTRAINT FK_FEEDBACK_REF_PROJET FOREIGN KEY (ref_projet) REFERENCES projet(id_projet));

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

CREATE TABLE Conseil (
id_conseil int PRIMARY KEY NOT NULL AUTO_INCREMENT, 
texte VARCHAR (255) NOT NULL, 
type VARCHAR (255) NOT NULL,
ref_utilisateur int NOT NULL,
CONSTRAINT FK_CONSEIL_REF_PROJET FOREIGN KEY (ref_utilisateur) REFERENCES utilisateur(id_utilisateur));

CREATE TABLE piscine(
id_piscine int NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR (255) NOT NULL,
ref_bmpn int NOT NULL,
CONSTRAINT FK_PISCINE_REF_BPMN FOREIGN KEY (ref_bmpn) REFERENCES bpmn(id_bpmn));

CREATE TABLE user_story(
id_user_story int NOT NULL PRIMARY KEY AUTO_INCREMENT,
contenu VARCHAR (255) NOT NULL,
ref_st int NOT NULL,
CONSTRAINT FK_USER_STORY_REF_ST FOREIGN KEY (ref_st) REFERENCES story_map(id_story_map));

CREATE TABLE epic(
id_epic int NOT NULL PRIMARY KEY AUTO_INCREMENT,
evenement VARCHAR (255) NOT NULL,
ref_st int NOT NULL,
CONSTRAINT FK_EPIC_REF_ST FOREIGN KEY (ref_st) REFERENCES story_map(id_story_map));

CREATE TABLE acteur(
id_acteur int NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(255) NOT NULL,
ref_mcf int,
CONSTRAINT FK_ACTEUR_REF_MCF FOREIGN KEY (ref_mcf) REFERENCES MCF(id_mcf));

CREATE TABLE activite_mcf(
id_activite_mcf int NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(255) NOT NULL,
ref_mcf int,
CONSTRAINT FK_ACTIVITE_MCF_REF_MCF FOREIGN KEY (ref_mcf) REFERENCES MCF(id_mcf));

CREATE TABLE flux(
id_flux int NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(255) NOT NULL,
direction VARCHAR(255) NOT NULL,
ref_acteur int,
ref_activite int,
CONSTRAINT FK_FLUX_REF_ACTEUR FOREIGN KEY (ref_acteur) REFERENCES acteur(id_acteur),
CONSTRAINT FK_FLUX_REF_ACTIVITE FOREIGN KEY (ref_activite) REFERENCES activite_mcf(id_activite_mcf));
