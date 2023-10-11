FROM nginx:mainline-alpine

RUN apk update \
    && apk upgrade \
    && apk add --no-cache openssl \
    && apk add --no-cache bash \
    && adduser -D -H -u 1000 -s /bin/bash www-data -G www-data

COPY --link .docker/nginx/startup.sh /opt/startup.sh
RUN ["chmod", "+x", "/opt/startup.sh"]

ARG APP_CODE_PATH
COPY --link .docker/nginx/default.conf /etc/nginx/conf.d/default.conf
RUN sed -i "s#__APP_CODE_PATH#$APP_CODE_PATH#" /etc/nginx/conf.d/default.conf

RUN sed -i 's/\r//g' /opt/startup.sh
#CMD ["/bin/bash", "/opt/startup.sh"]
RUN /opt/startup.sh