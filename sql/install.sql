-- Creates table users in the database.
CREATE TABLE users (
  user_id INT NOT NULL AUTO_INCREMENT,
  email TEXT,
  password VARCHAR(32),
  PRIMARY KEY (user_id)
);
CREATE TABLE vocabulary (
  vid INT NOT NULL AUTO_INCREMENT ,
  vocabulary VARCHAR(32) NOT NULL ,
  PRIMARY KEY (vid)
 );
INSERT INTO vocabulary (vid, vocabulary) VALUES (NULL, 'authors'), (NULL, 'categories');
CREATE TABLE terms (
  id INT NOT NULL AUTO_INCREMENT ,
  vid INT,  name VARCHAR(64) NOT NULL UNIQUE ,
  PRIMARY KEY  (id)
 );
CREATE TABLE field_authors (
  entity_id INT ,entity_type VARCHAR(32),
  term_id INT  ,
  PRIMARY KEY  (entity_id,entity_type,term_id)
 );
CREATE TABLE field_categories (
  entity_id INT ,
  entity_type VARCHAR(32),
  term_id INT  ,
  PRIMARY KEY  (entity_id,entity_type,term_id)
);
