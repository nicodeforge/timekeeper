#Timekeeper

This project is intended to run locally, on a basic wamp/lamp/mamp setup. It requires php 7, mysql 14 and an apache server.

##Setup instructions

Once downloaded, locate root directory to www/html

Before getting started, we're going to need to build the database :

###Database setup

Make sure you have mysql installed, then open terminal and run :

``
sudo mysql
``

``
CREATE DATABASE timekeeper;
``

``
CREATE USER 'timekeeper'@'localhost' IDENTIFIED BY 'timekeeping';
``

``
GRANT ALL PRIVILEGES ON * . * TO 'timekeeper'@'localhost';
``

``
FLUSH PRIVILEGES;
``

``
exit;
``

At this point, you should be able to connect to timekeeper's database using :

``
mysql -h localhost -u timekeeper -p'timekeeping' -D timekeeper
``
We're going to finish the setup :

``
ALTER DATABASE timekeeper CHARACTER SET utf8 COLLATE utf8_general_ci;
``

``
CREATE TABLE IF NOT EXISTS projects (project_id INT AUTO_INCREMENT, title VARCHAR(255) NOT NULL,priority INT, PRIMARY KEY (project_id)) ENGINE=INNODB;
``

``
CREATE TABLE IF NOT EXISTS log (entry_id INT AUTO_INCREMENT, project_id INT,length TIME,date_added DATE, PRIMARY KEY (entry_id),FOREIGN KEY (project_id) REFERENCES projects(project_id)) ENGINE=INNODB;
``


To manually add intended values :


You should see your project live now at localhost/timekeeper/

##Notice

Should you change database informations, make sure to update functionsdb.inc.php accordingly.



