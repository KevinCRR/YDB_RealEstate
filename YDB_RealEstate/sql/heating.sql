-- File: heating.sql
-- Author: Group 12
-- Date: 10/28/2019
-- Description: SQL file to create city property/value table

DROP TABLE IF EXISTS heating CASCADE;

CREATE TABLE heating(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE heating OWNER TO group12_admin;

INSERT INTO  heating(value, property) VALUES (1, 'Forced air');

INSERT INTO heating (value, property) VALUES (2, 'Boiler');

INSERT INTO heating (value, property) VALUES (4, 'Heat pumps');

INSERT INTO heating (value, property) VALUES (8, 'Furnace');

INSERT INTO heating (value, property) VALUES (16, 'Gas fired');

INSERT INTO heating (value, property) VALUES (32, 'Unvented');

INSERT INTO heating (value, property) VALUES (64, 'Electric');

INSERT INTO heating (value, property) VALUES (128, 'Fire place');

INSERT INTO heating (value, property) VALUES (256, 'Radiant');

INSERT INTO heating (value, property) VALUES (512, 'Floor Heat');

INSERT INTO heating (value, property) VALUES (1024, 'Other');
