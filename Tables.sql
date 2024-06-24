CREATE DATABASE  inventario_bd;

USE inventario_bd;

CREATE TABLE users(
	user_id 		INT(10) AUTO_INCREMENT PRIMARY KEY,
    user_name 		VARCHAR(25) NOT NULL,
    user_lastname 	VARCHAR(25) NOT NULL,
    user_nickname 	VARCHAR(20) NOT NULL,
    user_email		VARCHAR(25) NOT NULL,
    user_age 		INT(3) NOT NULL,
    user_password 	VARCHAR(60) NOT NULL
);

CREATE TABLE categories(
	categories_id		INT(7) AUTO_INCREMENT PRIMARY KEY,
    categories_name		VARCHAR(25) NOT NULL,
    categories_location VARCHAR(120) 
);


CREATE TABLE products(
	products_id				INT(7) AUTO_INCREMENT PRIMARY KEY,
    products_name			VARCHAR(25) NOT NULL,
    products_description	VARCHAR(125) NOT NULL,
    products_price			DECIMAL(10,2) NOT NULL,
    products_image			VARCHAR(500),
    products_stock			INT(10) NOT NULL,
    products_code			VARCHAR(25) NOT NULL,
    
    user_id					INT(10),
    categories_id			INT(7)
);

ALTER TABLE products
ADD CONSTRAINT fk_user_id
FOREIGN KEY (user_id) REFERENCES users(user_id);

ALTER TABLE products
ADD CONSTRAINT fk_categories_id
FOREIGN KEY (categories_id) REFERENCES categories(categories_id);


