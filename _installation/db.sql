CREATE TABLE users (
  user_id serial  PRIMARY KEY,
  user_name VARCHAR(64) UNIQUE,
  user_password_hash VARCHAR(255) NOT NULL,
  user_email VARCHAR(64) UNIQUE 
)  ;

CREATE TABLE IF NOT EXISTS tracker (
id serial PRIMARY KEY,
date DATE NOT NULL,
time TIME NOT NULL,
ip VARCHAR(64) NOT NULL,
country VARCHAR(64) NOT NULL,
city VARCHAR(64) NOT NULL,
query_string VARCHAR(64) NOT NULL,
http_referer VARCHAR(64) NOT NULL,
http_user_agent VARCHAR(64) NOT NULL,
isbot INTeger NOT NULL,
page VARCHAR(64)
);
