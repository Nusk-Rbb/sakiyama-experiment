-- 既存のテーブルを削除
DROP TABLE if exists seiseki_tbl;

-- テーブルを新規作成
CREATE TABLE seiseki_tbl (
	uid   INT  PRIMARY KEY,
	name  TEXT,
	score INT
);

-- 初期データの登録
INSERT INTO seiseki_tbl (uid, name, score) VALUES ( '100', '青木', '90' );
INSERT INTO seiseki_tbl (uid, name, score) VALUES ( '110', '池田', '85' );
INSERT INTO seiseki_tbl (uid, name, score) VALUES ( '120', '上田', '90' );

-- アクセス権限の設定
GRANT ALL ON seiseki_tbl TO apache;
