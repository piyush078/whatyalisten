# whatyalisten
An application that shows details about songs, albums and more.

### Description
This application uses [Laravel](https://laravel.com) and [Angular](https://angular.io) to show the information. Laravel fetches the Spotify API and responds on requests by Angular.

### Prerequisite
1. Before using the application, a [Spotify developer](https://developer.spotify.com) account is needed. It provides Client ID and Client Secret to work with its API. They are required to be stored before serving the application. Create a new file and put the following code in it. Save the file as ```client.php``` inside the ```api/config/``` folder of your application.
```
<?php
    return [
        'client_id' => '<your client id>',
        'client_secret' => '<your client secret>'
    ];
```
2. [Guzzle](http://docs.guzzlephp.org/en/stable) has be installed as a Laravel package. The steps to install it are on [this link](https://stackoverflow.com/questions/31741347/installation-guzzle-in-laravel-5).

### How it works
Serve the two folders [```api```](https://github.com/piyush078/whatyalisten/tree/master/api) and [```application```](https://github.com/piyush078/whatyalisten/tree/master/application) separately and use the Angular application on your browser.
