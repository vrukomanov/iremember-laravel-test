FROM mysql:5.7

#RUN mkdir -p /data/application

ARG MYSQL_DATABASE
ARG MYSQL_USER
ARG MYSQL_ROOT_PASSWORD
ARG MYSQL_PASSWORD

COPY --link .docker/mysql/init.sql /docker-entrypoint-initdb.d/01-databases.sql

RUN sed -i "s#__MYSQL_DATABASE#${MYSQL_DATABASE}#" /docker-entrypoint-initdb.d/01-databases.sql
RUN sed -i "s#__MYSQL_USER#${MYSQL_USER}#" /docker-entrypoint-initdb.d/01-databases.sql
RUN sed -i "s#__MYSQL_PASSWORD#${MYSQL_PASSWORD}#" /docker-entrypoint-initdb.d/01-databases.sql
#RUN sed -i "s#__MYSQL_ROOT_PASSWORD#${MYSQL_ROOT_PASSWORD}#" /docker-entrypoint-initdb.d/01-databases.sql

#RUN ln -s usr/local/bin/docker-entrypoint.sh /entrypoint.sh # backwards compat
#ENTRYPOINT ["docker-entrypoint.sh"]


#RUN printf "CREATE DATABASE IF NOT EXISTS '%s'; \n\
#CREATE DATABASE IF NOT EXISTS '%s_test'; \n\
#GRANT ALL PRIVILEGES ON '%s_test'.* TO '%s'@'%'; \n\" \
#    "${MYSQL_DATABASE}" "${MYSQL_DATABASE}" "${MYSQL_DATABASE}" "${MYSQL_USER}" > "/data/application/init.sql"

#RUN echo $'\
#CREATE DATABASE IF NOT EXISTS __MYSQL_DATABASE; \n\
#CREATE DATABASE IF NOT EXISTS __MYSQL_DATABASE_test; \n\
#GRANT ALL PRIVILEGES ON __MYSQL_DATABASE_test.* TO __MYSQL_USER;' > /data/application/init.sql

#RUN echo $'\
#CREATE DATABASE IF NOT EXISTS __MYSQL_DATABASE; \n\
#CREATE DATABASE IF NOT EXISTS __MYSQL_DATABASE_test; ' > /data/application/init.sql

#RUN sed -i "s#__MYSQL_DATABASE#${MYSQL_DATABASE}#" /data/application/init.sql
#RUN sed -i "s#__MYSQL_DATABASE_TEST#${MYSQL_DATABASE}_test#" /data/application/init.sql
#RUN sed -i "s#__MYSQL_USER#'${MYSQL_USER}'@'%'#" /data/application/init.sql

#CMD [ "--init-file", "/data/application/init.sql" ]


