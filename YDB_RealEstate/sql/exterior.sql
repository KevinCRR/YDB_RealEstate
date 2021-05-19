-- File: exterior.sql
-- Author: Group 12
-- Date: 10/28/2019
-- Description: SQL file to create exterior property/value table

DROP TABLE IF EXISTS exterior;

CREATE TABLE exterior(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE exterior OWNER TO group12_admin;

INSERT INTO exterior (value, property) VALUES (1, '<25 ft^2');

INSERT INTO exterior (value, property) VALUES (2, '>25 ft^2 and <50 ft^2');

INSERT INTO exterior (value, property) VALUES (4, '>50 ft^2 and <75 ft^2');

INSERT INTO exterior (value, property) VALUES (8, '>75 ft^2 and <100 ft^2');

INSERT INTO exterior (value, property) VALUES (16, '>100 ft^2 and <150 ft^2');

INSERT INTO exterior (value, property) VALUES (32, '>150 ft^2 and <200 ft^2');

INSERT INTO exterior (value, property) VALUES (64, '>200 ft^2 and <300 ft^2');

INSERT INTO exterior (value, property) VALUES (128, '>300 ft^2');
