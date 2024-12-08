DROP TABLE chumon;
DROP TABLE kokyaku;
DROP TABLE shohin;

CREATE TABLE shohin (
	code   INT  PRIMARY KEY,
	name   TEXT,
	price  INT,
	stock  INT
);

CREATE TABLE kokyaku (
	uid     INT  PRIMARY KEY,
	uname   TEXT UNIQUE,
	pass    TEXT,
	name    TEXT,
	address TEXT
);

CREATE TABLE chumon (
	id   INT  PRIMARY KEY,
	uid  INT  REFERENCES kokyaku(uid),
	code INT  REFERENCES shohin(code),
	num  INT
);

INSERT INTO shohin (code, name, price, stock) VALUES ('1', 'ボールペン', '120', '30');
INSERT INTO shohin (code, name, price, stock) VALUES ('2', 'えんぴつ'  ,  '80', '50');
INSERT INTO shohin (code, name, price, stock) VALUES ('3', '消しゴム'  ,  '50', '20');

GRANT ALL ON chumon  TO apache;
GRANT ALL ON kokyaku TO apache;
GRANT ALL ON shohin  TO apache;
