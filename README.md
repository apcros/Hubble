# Hubble

##### Staging
[![Build Status](https://travis-ci.org/apcros/Hubble.svg?branch=staging)](https://travis-ci.org/apcros/Hubble)

##### Master
[![Build Status](https://travis-ci.org/apcros/Hubble.svg?branch=master)](https://travis-ci.org/apcros/Hubble)

## Introduction

Hubble is a simple monitoring platform for Windows and Linux clients. (Server or not.) Greatly inspired by Zabbix, Observium and others.
This is basically a server with an API and the differents companions (clients) post to that API. 

Even though all of this tool is still very much work in progress, you can still use it : 
- Clone the repo and host the Server somewhere (Documentation will come soon)
- Add a new device from the HubbleWeb interface (in /devices)
- Launch the client setup the API endpoint, the UID and the device Key.
- The data should be updated and viewable on HubbleWeb :)

## API Documentation

The API Documentation is available on apiary : http://docs.hubbleweb.apiary.io/

## Project Kanban : 

You can track the project progress on taiga (If you have issue to raise, still use GitHub tracking for now.): 
https://tree.taiga.io/project/apcros-hubble/kanban


## Server
The server use **Laravel 5**
To create the database, just run : 

    php artisan migrate
  
If you want to spin-up a dev environement, just look at [HubbleBox](https://github.com/apcros/HubbleBox). 


- Version : **ALPHA 0.32**

##### Tools/Libs used :
- [Laravel 5](https://laravel.com/)
- [PostgreSQL](https://www.postgresql.org/)
- [MaterializeCSS](http://materializecss.com/)
- [FontAwesome](http://fontawesome.io/)
- [HandlebarsJs](http://handlebarsjs.com/)

##### Screenshots : 

**Home page**
![Home page](http://i.imgur.com/3NJpBWx.png)

**Devices page**
![Devices page](http://i.imgur.com/hvZMY98.png)

##### Clients

- [Windows](https://github.com/apcros/HubbleWin)
- Linux (Not yet available)
