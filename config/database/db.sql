CREATE DATABASE supply_chain_db;

USE supply_chain_db;

CREATE TABLE roles(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(20) NOT NULL
);

INSERT INTO
    roles (role)
VALUES
    ('admin'),
    ('manager'),
    ('transporter'),
    ('customer');

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(40) NOT NULL,
    middlename VARCHAR(40) NULL,
    lastname VARCHAR(40) NOT NULL,
    phone VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(200) NULL UNIQUE,
    role_id INT NOT NULL,
    password VARCHAR(255) NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles (id) ON UPDATE CASCADE
);

CREATE TABLE products(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(40) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE transport_companies(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(100) NOT NULL
);

CREATE TABLE vehicles(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    plate_number VARCHAR(10) NOT NULL,
    transport_company_id INT NOT NULL,
    FOREIGN KEY (transport_company_id) REFERENCES transport_companies(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE transport_company_owners(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    transport_company_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE,
    FOREIGN KEY (transport_company_id) REFERENCES transport_companies (id) ON UPDATE CASCADE
);

CREATE TABLE orders(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    quantity INT NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM ('PAID', 'NOT PAID') DEFAULT 'NOT PAID',
    FOREIGN KEY (product_id) REFERENCES products (id) ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE CASCADE
);

CREATE TABLE payments(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    control_no INT NOT NULL UNIQUE,
    amount DECIMAL(10, 2) NULL,
    order_id INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders (id) ON UPDATE CASCADE
);

CREATE TABLE transport_bookings (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    book_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders (id) ON UPDATE CASCADE,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles (id) ON UPDATE CASCADE
);