CREATE DATABASE prod; USE prod;

CREATE TABLE products ( ID int(255) NOT NULL AUTO_INCREMENT , Name varchar(255) NOT NULL, Color varchar(255) NOT NULL, Image varchar(500) NOT NULL, PRIMARY KEY (ID));

INSERT INTO products (ID, Name, Color, Image) VALUES (5, "Mask", "Red", "red.jpg"),(6, "Mask", "Yellow", "yellow.jpg"),(7, "Mask", "black", "black.jpg"); CREATE TABLE products_updated (ID int(255) NOT NULL AUTO_INCREMENT , Name varchar(255) NOT NULL, Status varchar(255) NOT NULL, EdTime datetime NOT NULL, PRIMARY KEY(ID));

 
