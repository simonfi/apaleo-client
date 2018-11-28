# ApaleoClient

Simple PHP Library for interacting with the Apaleo Open Hospitality Cloud (www.apaleo.com)

Built by Loopon for use in our own Guest Communication Suite (www.loopon.com) which is fully integrated with the Apaleo Open Hospitality Cloud, as well as to serve as a PHP example of how to integrate with Apaleo.

## Getting Started

This code has been written for and tested in PHP 7.1. It will not work on anything earlier than PHP 7 due to the usage of strict typing.

To do anything meaningful with this code, you first need to obtain credentials from Apaleo. Check https://apaleo.com/getting-started-with-apaleo-apis/ for details.

### Prerequisites

In order to use this example client, you need to install composer. See https://getcomposer.org/doc/00-intro.md

### Creating a completely new project using the ApaleoClient

Once you have composer installed, create an empty new project and create a `composer.json` file with the following contents:

```
{
    "name": "LooponAB/apaleo-client-test",
    "type": "project",
    "authors": [
        {
            "name": "Simon Finne",
            "email": "simon.finne@loopon.com"
        }
    ],
    "repositories": [
        {
            "name": "loopon/apaleo-client",
            "type": "git",
            "url": "https://github.com/LooponAB/apaleo-client.git"
        }
    ],
    "require": {
        "loopon/apaleo-client": "v1.x-dev"
    }
}
```

Then install the dependencies with the following command:

```
$ composer install
```

Now create a new file `ExampleClient.php` with the following contents:

```
<?php
require(__DIR__ . '/vendor/autoload.php');

$lApaleoClient = new Loopon\Apaleo\Client\Client('<URL OF YOUR APPLICATION>', '<USERNAME>', '<PASSWORD>');
$lInventory = $lApaleoClient->getInventoryApi()->getProperties();
print_r($lInventory);
```

Finally update the parameters to the `Client` constructor to match the credentials you have received from Apaleo.

## Testing the client

Simply run the code:

```
$ php ExampleClient.php
```

If you have setup your credentials correctly, the example will simply print the available inventory for your user. In case you only see an error message or stack trace, you most likely have provided incorrect credentials. 

## Using the library in your own project

In order to include the php library in your project, simply add the following entries to your composer.json file:

### Repositories entry:
 
```
    "repositories": [
        {
            "name": "loopon/apaleo-client",
            "type": "git",
            "url": "https://github.com/LooponAB/apaleo-client.git"
        }
    ],
```

### Requirements entry:

```
    "require": {
        "loopon/apaleo-client": "v1.x-dev"
    }
```

## Built With

* [The PHP League OAuth2](https://github.com/thephpleague/oauth2-client) - OAuth 2.0 Client


## Authors

* **Simon Finne** - *Initial implementation* - [simonfi](https://github.com/simonfi)


## License

This project is licensed under the 3-Clause BSD License - see the [LICENSE](LICENSE) file for details

## Contributing

Currently the Client is extremely limited and mostly serves as an example how to connect to Apaleo. Our intention is to keep updating it as Apaleo's API and our (www.loopon.com) usage of it evolves, but pull requests for new features are greatly appreciated.


## Acknowledgments

* Thank you to Andrea Stubbe at Apaleo for all the help while building Loopon's integration to the Apaleo Open Hospitality Cloud


