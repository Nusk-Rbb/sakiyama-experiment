docker cp app/db/initdb.sql postgres:/tmp
docker exec -it postgres psql -h localhost -p 5432 -U apache -d www -f /tmp/initdb.sql