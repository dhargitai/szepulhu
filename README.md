# szepul.hu Setup

Please follow the below steps to get started.

## Clone the project

Clone the project into your local file system:

```bash
git clone git@bitbucket.org:diatigrah/szepulhu.git
```

## Requirements

* Docker [docs.docker.com](https://docs.docker.com/installation)
* npm [npmjs.com](https://www.npmjs.com/#getting-started)

### For linux users

To be able to write the project files with your actual user you should run these commands:

```bash
sudo setfacl -R -m u:`whoami`:rwX application/
sudo setfacl -dR -m u:`whoami`:rwX application/
```

## Build development environment

```bash
./build.sh
```

After that you should be able to access the site at http://szepul.hu.dev.

## Rebuilding test data

To rebuild the data fixtures for the development environment you should use the

```bash
./console szepulhu:fixtures:load
```

command. It clears the whole database, recreate its schema, load the country/county/city information and generates the defined data fixtures.

## Using Symfony routes in javascript

You can generate Symfony routes in javascript files just like you do it in PHP.
In order to do that you have to expose the route you want to use in JS with adding and extra option in the route definition, e.g.

```php
/**
 * @Route("/everything-is-awesome", name="awesome_route_name", options={"expose"=true})
 */
```

Next step is to regenerate the JS file which will hold these exposed routes:
```bash
./console fos:js-routing:dump
```

After that you can use these routes in your javascript code like this:
```javascript
Routing.generate('awesome_route_name')
```

## Common Issues

#### Bower issue
You may have an error while bower tries to install its dependencies:
```bash
Failed to execute "git ls-remote --tags --heads git://github.com/jquery/jquery.git", exit code of #128
fatal: unable to connect to github.com:
github.com[0: 192.30.252.131]: errno=Connection refused
```

**Solution:** Run the following command on host:
```bash
git config --global url."https://".insteadOf git://
```

#### Behat problems
You may have problems when running Behat tests. As it is using the test environment which uses a class cache, maybe you need to clear the cache for that environment:
```bash
./console cache:clear --env=test
```


# License

Copyright 2015, Búza Géza & Hargitai Dávid 
