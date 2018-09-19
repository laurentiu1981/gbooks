-- Creates table users in the database.
CREATE TABLE users (
  user_id INT NOT NULL AUTO_INCREMENT,
  email TEXT,
  password VARCHAR(32),
  PRIMARY KEY (user_id)
);


-- Creates table books in the database.
CREATE TABLE books (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR (128),
  description TEXT,
  rating DECIMAL(10, 2),
  ISBN_13 VARCHAR(13),
  ISBN_10 VARCHAR(10),
  image VARCHAR(255),
  language VARCHAR(32),
  price DECIMAL(10, 2),
  currency VARCHAR(32),
  buy_link VARCHAR(255),
  PRIMARY KEY (id)
);
CREATE TABLE vocabulary (
  vid INT NOT NULL AUTO_INCREMENT ,
  vocabulary VARCHAR(32) NOT NULL ,
  PRIMARY KEY (vid)
 );
INSERT INTO vocabulary (vid, vocabulary) VALUES (NULL, 'authors'), (NULL, 'categories');
CREATE TABLE terms (
  tid INT NOT NULL AUTO_INCREMENT ,
  vid INT,  name VARCHAR(64) NOT NULL UNIQUE ,
  PRIMARY KEY  (tid)
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
CREATE TABLE configuration (
  name varchar(255),
  value LONGBLOB,
  PRIMARY KEY (name)
);
