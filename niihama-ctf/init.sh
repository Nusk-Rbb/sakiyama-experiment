docker exec -it postgres psql -h localhost -p 5432 -U apache -d www -f db/initdb.sql