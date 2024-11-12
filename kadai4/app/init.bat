docker cp db postgres:/tmp/
docker exec -it postgres psql -U apache -d www -f /tmp/db/init.sql
docker exec -it postgres psql -U apache -d www -f /tmp/db/seiseki.sql