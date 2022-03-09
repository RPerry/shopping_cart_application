-- create the tables
CREATE TABLE products (
  productID INT(12) NOT NULL AUTO_INCREMENT,
  productName VARCHAR(255)  NOT NULL,
  productDescription  VARCHAR(800)  NOT NULL,
  productPrice  FLOAT(6,2)  NOT NULL,
  productQuantity INT(255)  NOT NULL,
  PRIMARY KEY (productID)
);

CREATE TABLE customers (
  customerID VARCHAR(12) NOT NULL,
  firstName VARCHAR(255) NOT NULL,
  lastName VARCHAR(255) NOT NULL,
  PRIMARY KEY (customerID)
);

CREATE TABLE carts (
  cartID  INT(11) AUTO_INCREMENT,
  PRIMARY KEY (cartID)
);

CREATE TABLE admins (
  adminID  VARCHAR(255) NOT NULL,
  adminPass VARCHAR(255) NOT NULL,
  PRIMARY KEY (adminID)
);

CREATE TABLE cart_products (
    cartProductID INT(11) NOT NULL AUTO_INCREMENT,
    cartID  INT(11) NOT NULL,
    productName VARCHAR(255)  NOT NULL,
    quantity INT(11) NOT NULL,
    productID INT(12) NOT NULL,
    PRIMARY KEY (cartProductID)
);

CREATE TABLE orders (
    orderID INT(12) NOT NULL AUTO_INCREMENT, 
    customerID  VARCHAR(12) NOT NULL,
    cartID  INT(11) NOT NULL,
    PRIMARY KEY (orderID)
);

ALTER TABLE cart_products
ADD FOREIGN KEY (cartID) REFERENCES carts(cartID); 

ALTER TABLE cart_products
ADD FOREIGN KEY (productID) REFERENCES products(productID); 

ALTER TABLE orders
ADD FOREIGN KEY (cartID) REFERENCES carts(cartID);

ALTER TABLE orders
ADD FOREIGN KEY (customerID) REFERENCES customers(customerID);

INSERT INTO products VALUES
(1, 'Badges the Dog', 'A brown dog', 14.99, 5),
(2, 'Bahati the African Elephant', 'A gray and brown elephant', 15.99, 4),
(3, 'Baldy the Bald Eagle', 'A white, yellow and black eagle', 6.99, 10),
(4, 'Bali the Komodo Dragon', 'A brown komodo dragon', 14.99, 5),
(5, 'Baltic the Husky Dog', 'A white and gray dog', 6.99, 5);

INSERT INTO customers VALUES
('gk123', 'Greg', 'Kensey'),
('beaniefan4', 'John', 'Smith');

INSERT INTO carts VALUES
(1),
(2),
(3);

INSERT INTO cart_products VALUES
(1, 1, 'Bahati the African Elephant', 1, 2),
(2, 1, 'Baldy the Bald Eagle', 2, 3),
(3, 1, 'Bali the Komodo Dragon', 1, 4),
(4, 2, 'Badges the Dog', 3, 1),
(5, 2, 'Bahati the African Elephant', 1, 2),
(6, 3, 'Baldy the Bald Eagle', 1, 3);

INSERT INTO orders VALUES
(1, 'gk123', 1),
(2, 'beaniefan4', 2),
(3, 'gk123', 3);

INSERT INTO admins VALUES
('riyop', 'testPass'),
('otherAdmin', 'anotherTestPass');
