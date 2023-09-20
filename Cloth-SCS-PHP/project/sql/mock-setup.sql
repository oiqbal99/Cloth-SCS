/*
The `mock-setup.sql` file initializes everything needed for quick use, and uses
mock data as an example for demo purposes later on. Feel free to contribute :^)

All of this file's contents are meant to be run exactly once in PHPMyAdmin,
under the "mockdb" database.

See "query.php" for specifics related to the database connection.
*/

-- Table Deletion (Optional)

DROP TABLE IF EXISTS `Item`;
DROP TABLE IF EXISTS `Order`;
DROP TABLE IF EXISTS `Trip`;
DROP TABLE IF EXISTS `Truck`;
DROP TABLE IF EXISTS `Shopping`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `pricematch`;

-- Table Creation

CREATE TABLE `Item` (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  source VARCHAR(255) NOT NULL,
  department VARCHAR(255) NOT NULL,
  image_url VARCHAR(1000) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE `User` (
  id INT(11) NOT NULL AUTO_INCREMENT,
  login_id VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(1000) NOT NULL,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  phone VARCHAR(255) NOT NULL,
  address VARCHAR(255) NOT NULL,
  city_code VARCHAR(255) NOT NULL,
  balance INT(11) NOT NULL DEFAULT 0,
  is_admin BOOLEAN NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
);

CREATE TABLE `Truck` (
  id INT(11) NOT NULL AUTO_INCREMENT,
  truck_code VARCHAR(255) NOT NULL,
  availability_code VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE `Shopping` (
  id INT(11) NOT NULL AUTO_INCREMENT,
  store_code VARCHAR(255) NOT NULL,
  total_price INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE `Trip` (
  id INT(11) NOT NULL AUTO_INCREMENT,
  source_code VARCHAR(255) NOT NULL,
  destination_code VARCHAR(255) NOT NULL,
  distance VARCHAR(255) NOT NULL,
  truck_id INT(11) NOT NULL,
  price VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (truck_id) REFERENCES Truck(id)
);

CREATE TABLE `Order` (
  id INT(11) NOT NULL AUTO_INCREMENT,
  date_issued VARCHAR(255) NOT NULL,
  date_received VARCHAR(255) NOT NULL,
  total_price VARCHAR(255) NOT NULL,
  payment_code VARCHAR(15) NOT NULL,
  user_id INT(11) NOT NULL,
  trip_id INT(11) NOT NULL,
  receipt_id INT(11) NOT NULL,
  completed BOOLEAN NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES User(id),
  FOREIGN KEY (trip_id) REFERENCES Trip(id),
  FOREIGN KEY (receipt_id) REFERENCES Shopping(id)
);

CREATE TABLE `Review` (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  item_id INT(11) NOT NULL,
  rating_number INT NOT NULL,
  review_text VARCHAR (1000) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES User(id),
  FOREIGN KEY (item_id) REFERENCES Item(id),
  PRIMARY KEY (id) 
);

CREATE TABLE `pricematch` (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  source VARCHAR(255) NOT NULL,
  department VARCHAR(255) NOT NULL,
  image_url VARCHAR(1000) NOT NULL,
  PRIMARY KEY (id)
);

-- Mock Data Inserts

INSERT INTO Item (name, price, source, department, image_url) VALUES ('T-Shirt', 7.99, 'Canada', 'SHIRTS', 'https://renocountry.ca/wp-content/uploads/2021/09/tshirt-2.jpg');
INSERT INTO Item (name, price, source, department, image_url) VALUES ('Orange T-Shirt', 8.99, 'China', 'SHIRTS', 'https://mlnorthern.ca/wp-content/uploads/2018/05/vneck-tee-2.jpg');
INSERT INTO Item (name, price, source, department, image_url) VALUES ('Green Long Sleeve Shirt', 10.99, 'Switzerland', 'SHIRTS', 'https://renocountry.ca/wp-content/uploads/2021/09/long-sleeve-tee-2.jpg');
INSERT INTO Item (name, price, source, department, image_url) VALUES ('Red Beanie', 6.99, 'Switzerland', 'HATS', 'https://renocountry.ca/wp-content/uploads/2021/09/beanie-2.jpg');
INSERT INTO Item (name, price, source, department, image_url) VALUES ('Yellow Cap', 8.99, 'Canada', 'HATS', 'https://renocountry.ca/wp-content/uploads/2021/09/cap-2.jpg');
INSERT INTO Item (name, price, source, department, image_url) VALUES ('Sunglasses', 14.99, 'Germany', 'ACCESSORIES', 'https://renocountry.ca/wp-content/uploads/2021/09/sunglasses-2.jpg');


INSERT INTO pricematch (name, price, source, department, image_url) VALUES ('T-Shirt', 11.99, 'Canada', 'SHIRTS', 'https://renocountry.ca/wp-content/uploads/2021/09/tshirt-2.jpg');
INSERT INTO pricematch (name, price, source, department, image_url) VALUES ('Orange T-Shirt', 33.99, 'China', 'SHIRTS', 'https://mlnorthern.ca/wp-content/uploads/2018/05/vneck-tee-2.jpg');
INSERT INTO pricematch (name, price, source, department, image_url) VALUES ('Green Long Sleeve Shirt', 31.99, 'Switzerland', 'SHIRTS', 'https://renocountry.ca/wp-content/uploads/2021/09/long-sleeve-tee-2.jpg');
INSERT INTO pricematch (name, price, source, department, image_url) VALUES ('Red Beanie', 16.99, 'Switzerland', 'HATS', 'https://renocountry.ca/wp-content/uploads/2021/09/beanie-2.jpg');
INSERT INTO pricematch (name, price, source, department, image_url) VALUES ('Yellow Cap', 11.99, 'Canada', 'HATS', 'https://renocountry.ca/wp-content/uploads/2021/09/cap-2.jpg');
INSERT INTO pricematch (name, price, source, department, image_url) VALUES ('Sunglasses', 16.99, 'Germany', 'ACCESSORIES', 'https://renocountry.ca/wp-content/uploads/2021/09/sunglasses-2.jpg');

INSERT INTO User (login_id, password, name, email, address, phone, city_code, is_admin) VALUES ('AdminDoe', '123chicken123', 'John Doe', 'john.doe@clothscs.com', '1234 Street St', '6471112222', '647', 1);
INSERT INTO User (login_id, password, name, email, address, phone, city_code) VALUES ('UserDoe', '123chicken123', 'Jane Doe', 'jane.doe123@gmail.com', '4321 Avenue Av', '4162221111', '416');

INSERT INTO Shopping (store_code, total_price) VALUES ('1', 9);
INSERT INTO Shopping (store_code, total_price) VALUES ('2', 7);

INSERT INTO Truck (truck_code, availability_code) VALUES ('123', '456');
INSERT INTO Truck (truck_code, availability_code) VALUES ('123', '456');

INSERT INTO Trip (source_code, destination_code, distance, truck_id, price) VALUES ('123', '456', '10km', 1, "$5");
INSERT INTO Trip (source_code, destination_code, distance, truck_id, price) VALUES ('123', '456', '10km', 2, "$5");

INSERT INTO `Order` (date_issued, date_received, total_price, payment_code, user_id, trip_id, receipt_id, completed) VALUES ('01/23/2023', '01/26/2023', '$7.99', '123', 1, 1, 1, 1);
INSERT INTO `Order` (date_issued, date_received, total_price, payment_code, user_id, trip_id, receipt_id) VALUES ('01/23/2023', 'N/A', '$8.99', '456', 2, 1, 2);

INSERT INTO Trip (source_code, destination_code, distance, truck_id, price) VALUES ('123', '456', '10km', 1, "$5");
INSERT INTO Trip (source_code, destination_code, distance, truck_id, price) VALUES ('123', '456', '10km', 2, "$5");