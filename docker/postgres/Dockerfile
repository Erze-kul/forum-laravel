FROM postgres:11.5

ARG UID
ARG GID
RUN usermod -u ${UID} www-data
RUN groupmod -g ${GID} www-data
