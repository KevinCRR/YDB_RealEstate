-- File: bathrooms.sql
-- Author: Group 12
-- Date: 10/28/2019
-- Description: SQL file to create bathrooms property/value table

DROP TABLE IF EXISTS bathrooms;

CREATE TABLE bathrooms(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE bathrooms OWNER TO group12_admin;

INSERT INTO bathrooms (value, property) VALUES (1, 'One Bathroom');

INSERT INTO bathrooms (value, property) VALUES (2, 'Two Bathrooms');

INSERT INTO bathrooms (value, property) VALUES (4, 'Three Bathrooms');

INSERT INTO bathrooms (value, property) VALUES (8, 'Four Bathrooms');

INSERT INTO bathrooms (value, property) VALUES (16, 'Five Bathrooms');

INSERT INTO bathrooms (value, property) VALUES (32, 'Six Bathrooms');

INSERT INTO bathrooms (value, property) VALUES (64, 'Seven Bathrooms');
