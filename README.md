# Hubble

Hubble is a simple monitoring platform for Windows and Linux clients. (Server or not.) Greatly inspired by Zabbix, Observium and others.
This is basically a server with an API and the differents companions (clients) post to that API. 

Even though all of this tool is still very much work in progress, you can still use it : 
- Clone the repo and host the Server somewhere (You can use the vagrant box and expose the port 80)
- Generate a UID from the HubbleWeb interface (in /config)
- Launch the client setup the API endpoint and the UID
- The data should be updated and viewable on HubbleWeb :)

## Server
The server use **Laravel 5** and a VagrantFile is provided

The SQL script used during provisionning is hubble_schema.sql and the bash provisioning script is initialize.sh
- Version : **PRE ALPHA 0.01**

##### Tools/Libs used :
- Laravel 5
- PostgreSQL
- Vagrant
- MaterializeCSS
- FontAwesome

##### Screenshots : 

**Home page**
![Home page](https://raw.github.com/apcros/Hubble/master/home.png)

**Config page**
![Config page](https://raw.github.com/apcros/Hubble/master/config.png)

## Windows Client
The Windows Client use C# and the Windows API
Binary are provided (In the releases), If you want to compile it yourself, go ahead, you should have everything you need in Clients/Win
- Version : **0.1**

## Linux Client
Todo
