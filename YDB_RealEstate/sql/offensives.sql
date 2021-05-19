DROP TABLE IF EXISTS offensives;

CREATE TABLE offensives(
  user_id VARCHAR(20) NOT NULL,
  listing_id INTEGER NOT NULL,
  reported_on DATE NOT NULL,
  status CHAR(1) NOT NULL,

  PRIMARY KEY (user_id, listing_id),
  FOREIGN KEY (user_id) REFERENCES users (user_id),
  FOREIGN KEY (listing_id) REFERENCES listings (listing_id)
);

ALTER TABLE offensives OWNER TO group12_admin;
