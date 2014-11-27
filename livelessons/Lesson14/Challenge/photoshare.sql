
DROP Database PhotoShareApp;

CREATE DATABASE PhotoShareApp
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;


GRANT SELECT,UPDATE,INSERT,DELETE
    ON PhotoShareApp.*
    TO 'psa_user'@'localhost'
    IDENTIFIED BY 'secret_password';


USE PhotoShareApp;


CREATE TABLE Users
(
  id INTEGER AUTO_INCREMENT PRIMARY KEY,
  user_name VARCHAR(100) NOT NULL UNIQUE,
  full_name VARCHAR(255) NOT NULL,
  password VARCHAR(32) NOT NULL,
  email_address VARCHAR(255) NOT NULL,
  join_date DATETIME,
  last_login DATETIME,
  priv_level INTEGER NOT NULL DEFAULT 0,

  INDEX(user_name)
)
ENGINE = InnoDB;


CREATE TABLE UserBios
(
  userid INTEGER NOT NULL,
  userbio TEXT,

  INDEX(userid),
  FULLTEXT(userbio)
)
ENGINE = MyISAM;

