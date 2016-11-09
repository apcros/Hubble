# Hubble

Hubble is a simple monitoring platform for Windows and Linux clients. (Server or not.) Greatly inspired by Zabbix, Observium and others.
This is basically a server with an API and the differents companions (clients) post to that API. 

Even though all of this tool is still very much work in progress, you can still use it : 
- Clone the repo and host the Server somewhere (Documentation will come soon)
- Generate a UID from the HubbleWeb interface (in /config)
- Launch the client setup the API endpoint and the UID
- The data should be updated and viewable on HubbleWeb :)

## Server
The server use **Laravel 5** and a VagrantFile is provided for development purpose.

The SQL script used during provisionning is hubble_schema.sql and the bash provisioning script is initialize.sh
- Version : **PRE ALPHA 0.01**

##### Tools/Libs used :
- Laravel 5
- PostgreSQL
- Vagrant
- MaterializeCSS
- FontAwesome

##### TODO : 

- Providing a Docker image for the server
- Apiary docs
- Moving the SQL script to a DatabaseSeeding class

##### Screenshots : 

**Home page**
![Home page](http://i.imgur.com/0YMDiCj.png)

**Config page**
![Config page](http://i.imgur.com/ka5eAJz.png)

##### Clients

- [Windows](https://github.com/apcros/HubbleWin)
- Linux (Not yet available)
