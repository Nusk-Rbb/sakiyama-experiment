psql -h localhost -p 5432 -U apache -d www -f db/init.utf8.sql
psql -h localhost -p 5432 -U apache -d www -f samples/pgsql/seiseki.utf8.sql