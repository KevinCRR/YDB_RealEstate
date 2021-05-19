-- File: city.sql
-- Author: Group 12
-- Date: 10/28/2019
-- Description: SQL file to create city property/value table

DROP TABLE IF EXISTS bedrooms;

CREATE TABLE bedrooms(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE bedrooms OWNER TO group12_admin;

INSERT INTO bedrooms (value, property) VALUES (1, 'One Bedroom');

INSERT INTO bedrooms (value, property) VALUES (2, 'Two Bedrooms');

INSERT INTO bedrooms (value, property) VALUES (4, 'Three Bedrooms');

INSERT INTO bedrooms (value, property) VALUES (8, 'Four Bedrooms');

INSERT INTO bedrooms (value, property) VALUES (16, 'Five Bedrooms');

INSERT INTO bedrooms (value, property) VALUES (32, 'Six Bedrooms');

INSERT INTO bedrooms (value, property) VALUES (64, 'Seven Bedrooms');
