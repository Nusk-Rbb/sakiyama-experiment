truncate table city_table, school_table;
drop table if exists school_table, city_table;

create table city_table (
    cid int primary key,
    city text
);

create table school_table (
    sid int primary key,
    school text,
    cid int references city_table(cid)
);

insert into city_table values (10, '新居浜市'); 
insert into city_table values (11, '四国中央市'); 
insert into city_table values (12, '西条市'); 
insert into city_table values (13, '今治市'); 

insert into school_table values (1, '新居浜西高等学校', 10); 
insert into school_table values (2, '新居浜南高等学校', 10); 
insert into school_table values (3, '西条北高等学校', 12); 

select school_table.sid, school_table.school, city_table.city from school_table inner join city_table on school_table.cid = city_table.cid;