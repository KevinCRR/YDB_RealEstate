-- File: city.sql
-- Author: Group 12
-- Date: 10/28/2019
-- Description: SQL file to create city property/value table

DROP TABLE IF EXISTS types_of_listing;

CREATE TABLE types_of_listing(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE types_of_listing OWNER TO group12_admin;

INSERT INTO types_of_listing (value, property) VALUES (1, 'House');

INSERT INTO types_of_listing (value, property) VALUES (2, 'Condo');

INSERT INTO types_of_listing (value, property) VALUES (4, 'Commercial');

INSERT INTO types_of_listing (value, property) VALUES (8, 'Other');
