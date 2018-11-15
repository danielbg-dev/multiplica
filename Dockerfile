FROM rrcfesc/dockerfilesmagento2:5.6

LABEL maintainer="rrcfesc@gmail.com"

ADD src/index.php /var/www/html/index.php

EXPOSE 80 443
