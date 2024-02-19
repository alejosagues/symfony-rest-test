CREATE TABLE product (
    id SERIAL PRIMARY KEY, name VARCHAR(64) NOT NULL, price INT NOT NULL
);

CREATE TABLE coupon (
    id SERIAL PRIMARY KEY, code VARCHAR(64) NOT NULL, percentage DECIMAL(5, 2) NOT NULL, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, expires_at TIMESTAMP
);

INSERT INTO
    product (name, price)
VALUES ('iPhone', 100),
    ('Headphones', 20),
    ('Case', 10);

INSERT INTO
    coupon (code, percentage)
VALUES ('P10', 10.00),
    ('P100', 100.00),
    ('P20', 20.00);