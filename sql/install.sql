-- Creates table users in the database.
CREATE TABLE users (
  user_id INT NOT NULL AUTO_INCREMENT,
  email TEXT,
  password VARCHAR(32),
  PRIMARY KEY (user_id)
)