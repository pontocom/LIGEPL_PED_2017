CREATE TABLE contacto (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(200) NOT NULL,
  morada TEXT NOT NULL,
  telefone VARCHAR(20) NOT NULL,
  email VARCHAR(120) NOT NULL,
  foto VARCHAR(120),
  id_user_contacto INTEGER,
  FOREIGN KEY (id_user_contacto) REFERENCES user_pim(id)
);

CREATE TABLE user_pim (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(200) NOT NULL,
  passwd VARCHAR(60) NOT NULL
);