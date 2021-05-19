-- File: stories.sql
-- Author: Group 12
-- Date: 10/28/2019
-- Description: SQL file to create stories property/value table

DROP TABLE IF EXISTS stories;

CREATE TABLE stories(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE stories OWNER TO group12_admin;

INSERT INTO stories (value, property) VALUES (1, 'One Story');

INSERT INTO stories (value, property) VALUES (2, 'Two Stories');

INSERT INTO stories (value, property) VALUES (4, 'Three Stories');

INSERT INTO stories (value, property) VALUES (8, 'Four Stories');

INSERT INTO stories (value, property) VALUES (16, 'Five Stories');

INSERT INTO stories (value, property) VALUES (32, 'Six Stories');

INSERT INTO stories (value, property) VALUES (64, 'Seven Stories');
