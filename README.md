# Docker phpMyAdmin 4.9.1 & PHP-FPM 7.3 & Nginx 1.16 on Alpine Linux

[phpMyAdmin-fpm](https://github.com/phpmyadmin/docker) installed on [TrafeX's PHP-FPM & Nginx Alpine](https://github.com/TrafeX/docker-php-nginx) image.

## Usage

```
docker run --name phpmyadmin -d -p 8080:8080 moonbuggy/phpmyadmin
```

Environmental variables can be specified with the `-e` flag. Available environmental variables are:

* ``PMA_ARBITRARY`` - when set to 1 connection to the arbitrary server will be allowed
* ``PMA_HOST`` - define address/host name of the MySQL server
* ``PMA_VERBOSE`` - define verbose name of the MySQL server
* ``PMA_PORT`` - define port of the MySQL server
* ``PMA_HOSTS`` - define comma separated list of address/host names of the MySQL servers
* ``PMA_VERBOSES`` - define comma separated list of verbose names of the MySQL servers
* ``PMA_PORTS`` -  define comma separated list of ports of the MySQL servers
* ``PMA_USER`` and ``PMA_PASSWORD`` - define username to use for config authentication method
* ``PMA_ABSOLUTE_URI`` - define user-facing URI

This image should run basically the same way the official phpMyAdmin image does and a more detailed description is available on their [GitHub](https://github.com/phpmyadmin/docker) or [DockerHub](https://hub.docker.com/r/phpmyadmin/phpmyadmin) pages.

### Example docker-compose.yml

This example assumes you have [Traefik v2](https://hub.docker.com/_/traefik) running in another container, ready to proxy. If you don't just remove the references to the `traefik` network.

```
version: '2'

services:
  mariadb:
    image: jbergstroem/mariadb-alpine
    container_name: mariadb
    restart: unless-stopped
    ports:
      - 3306:3306
    volumes:
      - mariadb:/var/lib/mysql
    environment:
      - "MYSQL_DATABASE=phpmyadmin"
      - "MYSQL_USER=user"
      - "MYSQL_PASSWORD=password"
    networks:
      - sql
      - traefik

  phpmyadmin:
    image: moonbuggy2000/phpmyadmin-alpine
    container_name: phpmyadmin
    depends_on:
      - mariadb
    restart: unless-stopped
    ports:
      - 8080:8080
    environment:
      - "PMA_ABSOLUTE_URI=phpmyadmin.local"
      - "PMA_HOST=mariadb"
      - "PMA_PORT=3306"
      - "PMA_USER=user"
      - "PMA_PASSWORD=password"
    labels:
      - "traefik.enable=true"
      - "traefik.http.routers.phpmyadmin.rule=Host(`phpmyadmin.local`)"
      - "traefik.http.services.phpmyadmin.loadbalancer.server.port=8080"
    networks:
      - sql
      - traefik

volumes:
  mariadb:
    name: mariadb

networks:
  sql:
    driver: bridge
    name: sql
  traefik:
    external:
      name: traefik
```
