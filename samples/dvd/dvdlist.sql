-- 既存のテーブルを削除
DROP TABLE dvdtable1;
DROP TABLE dvdtable2;

-- テーブルを新規作成
CREATE TABLE dvdtable2 (
	mid   INT  PRIMARY KEY,
	maker TEXT
);

CREATE TABLE dvdtable1 (
	id    INT  PRIMARY KEY,
	title TEXT,
	mid   INT  REFERENCES dvdtable2(mid)
);

-- 初期データの登録
INSERT INTO dvdtable2 (mid, maker) VALUES ('1', 'SONY');
INSERT INTO dvdtable2 (mid, maker) VALUES ('2', 'Victor');
INSERT INTO dvdtable2 (mid, maker) VALUES ('3', 'Pioneer');

INSERT INTO dvdtable1 (id, title, mid) VALUES ('1', 'Spiderman', '1');

-- アクセス権限の設定
GRANT ALL ON dvdtable1 TO apache;
GRANT ALL ON dvdtable2 TO apache;
