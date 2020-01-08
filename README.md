## Usage

To get gulp to manage scss and js compiling open Terminal and follow these instructions:


cd YOUR_LOCAL_PATH/wp-content/themes/FIH
npm install <br>
gulp watch-bs

To run a local instence of the size via Docker:

* Install docker from [https://www.docker.com/](https://www.docker.com/)
* In Terminal: <br>
  cd YOUR_LOCAL_PATH <br>
  docker-compose up <br>
  Full guide [here](https://upcloud.com/community/tutorials/wordpress-with-docker/)

* Your WordPress installation will be available at `http://localhost:8000`

To import a database: <br>
In Terminal: docker exec -i DB_CONTAINER_NAME mysql -uroot -ppassword --database=wordpress < BACKUPFILE.sql <br>
[https://blog.shanelee.name/2017/04/09/how-to-import-and-export-databases-in-mysql-or-mariadb-with-docker/#importingthedatabaseintodockercontainer](more info here)

To export a datebase: <br>
* In Terminal: <br>
cd to a folder you wish to keep your back up. i.e: cd YOUR_LOCAL_PATH/backups <br>

docker exec CONTAINERNAME /usr/bin/mysqldump -u USERNAME --password=PASSWORD MYSQL_DATABASE > backup.sql

Replace all in capitals with actual credentials. You may get this info from Kitematic (Docker menu > Kitematic > relevant container )


