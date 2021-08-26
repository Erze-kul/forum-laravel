FROM postgres:13.4

ARG UID
ARG GID
RUN usermod -u ${UID} www-data
RUN groupmod -g ${GID} www-data

RUN chmod 775 "$PGDATA"
