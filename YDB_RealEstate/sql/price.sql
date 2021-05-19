-- File: price.sql
-- Author: Group 12
-- Date: 10/28/2019
-- Description: SQL file to create price property/value table

DROP TABLE IF EXISTS price;

CREATE TABLE price(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE price OWNER TO group12_admin;

INSERT INTO price (value, property) VALUES (1, 'Low Tier');

INSERT INTO price (value, property) VALUES (2, 'Mid-Low Tier');

INSERT INTO price (value, property) VALUES (4, 'Mid Tier');

INSERT INTO price (value, property) VALUES (8, 'Mid-High Tier');

INSERT INTO price (value, property) VALUES (16, 'High Tier');
