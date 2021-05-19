-- File: property_options.sql
-- Author: Group 12
-- Date: 10/28/2019
-- Description: SQL file to create property_options property/value table

DROP TABLE IF EXISTS property_options;

CREATE TABLE property_options(
	value INT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

ALTER TABLE property_options OWNER TO group12_admin;

INSERT INTO property_options (value, property) VALUES (1, 'Garage');

INSERT INTO property_options (value, property) VALUES (2, 'AC');

INSERT INTO property_options (value, property) VALUES (4, 'Pool');

INSERT INTO property_options (value, property) VALUES (8, 'Acreage');

INSERT INTO property_options (value, property) VALUES (16, 'Waterfront');

INSERT INTO property_options (value, property) VALUES (32, 'Apartment');

INSERT INTO property_options (value, property) VALUES (64, 'Condominium');

INSERT INTO property_options (value, property) VALUES (128, 'Bungalow');

INSERT INTO property_options (value, property) VALUES (256, 'Two-Story');

INSERT INTO property_options (value, property) VALUES (512, 'Walkout');
