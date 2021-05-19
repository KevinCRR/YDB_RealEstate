DROP TABLE IF EXISTS favourites;

CREATE TABLE favourites(
  favourite_id VARCHAR(40) PRIMARY KEY,
  user_id VARCHAR(20) NOT NULL,
  listing_id INTEGER NOT NULL,

  FOREIGN KEY (user_id) REFERENCES users (user_id),
  FOREIGN KEY (listing_id) REFERENCES listings (listing_id)
);

ALTER TABLE favourites OWNER TO group12_admin;
