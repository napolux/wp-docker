## Usage

To run a local instence of the size via Docker:

* Install docker from [https://www.docker.com/](https://www.docker.com/)
* Full guide [here](https://upcloud.com/community/tutorials/wordpress-with-docker/)
* to use it run docker and the two containers (wordpress and db) and go to [http://localhost/](http://localhost/)

* Your WordPress installation will be available at `http://localhost:8000`

*To get gulp to manage scss and js compiling open Terminal and follow these instructions:

cd YOUR_LOCAL_PATH/wp-content/themes/FIH
npm install <br>
gulp watch-bs

*To export a datebase: <br>
In Terminal: <br>
cd to a folder you wish to keep your back up. i.e: cd YOUR_LOCAL_PATH/backups <br>

docker run -it --link DBCONTAINERNAME:mysql \
   --rm mariadb:latest \
   sh -c 'exec mysqldump -h"$MYSQL_PORT_3306_TCP_ADDR" -P"$MYSQL_PORT_3306_TCP_PORT" -uroot -p"$MYSQL_ENV_MYSQL_ROOT_PASSWORD" DATABASENAME' > database_name_dump.sql

Replace all in capitals with actual credentials. You may get this info from Kitematic (Docker menu > Kitematic > relevant container )

*To import a database: <br>
In Terminal: docker exec -i DB_CONTAINER_NAME mysql -uroot -ppassword --database=wordpress < BACKUPFILE.sql <br>
[more info here](https://blog.shanelee.name/2017/04/09/how-to-import-and-export-databases-in-mysql-or-mariadb-with-docker/#importingthedatabaseintodockercontainer)


