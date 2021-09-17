CREATE TABLE IF NOT EXISTS swingstrdb (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id),
  email VARCHAR(256),
  ename VARCHAR(512),
  estart DATETIME,
  eend DATETIME,
  eplace VARCHAR(512),
  edesc TEXT,
  ecat TINYINT,
  estat TINYINT,
  emod VARCHAR(128)
);