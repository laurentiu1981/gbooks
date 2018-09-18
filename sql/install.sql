-- Creates table users in the database.
CREATE TABLE users (
  user_id INT NOT NULL AUTO_INCREMENT,
  email TEXT,
  password VARCHAR(32),
  PRIMARY KEY (user_id)
)


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
  buy_link - VARCHAR(255),
  PRIMARY KEY (id)
)
