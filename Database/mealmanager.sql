CREATE TABLE meals (
  id INT (11) NOT NULL AUTO_INCREMENT,
  title VARCHAR (64) NOT NULL,
  category VARCHAR (16),
  addeddt DATETIME,
  lasteatendt DATETIME NOT NULL,
  notes VARCHAR (255),
  PRIMARY KEY (id)
);

CREATE TABLE ingredients (
  id INT (11) NOT NULL AUTO_INCREMENT,
  mealid INT (11) NOT NULL,
  ingredientname VARCHAR (64) NOT NULL,
  approxcost DECIMAL (5, 2) NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
);

CREATE TABLE meallog (
  id INT (11) NOT NULL AUTO_INCREMENT,
  mealid INT (11) NOT NULL,
  dt DATETIME NOT NULL,
  PRIMARY KEY (id)
);