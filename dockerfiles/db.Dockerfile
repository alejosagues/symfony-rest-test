FROM postgres:16.1

COPY ../config/docker-entrypoint-initdb.d docker-entrypoint-initdb.d