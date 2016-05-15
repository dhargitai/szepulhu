# szepul.hu Setup

Please follow the below steps to get started.

## Clone the project

Clone the project into your local file system:

```bash
git clone git@bitbucket.org:diatigrah/szepulhu.git
```

## Requirements

* Docker [docs.docker.com](https://docs.docker.com/installation)
* Docker Compose [docs.docker.com/compose/install](https://docs.docker.com/compose/install/)

### For linux users

To be able to write the project files with your actual user you should run these commands:

```bash
sudo setfacl -R -m u:`whoami`:rwX application/
sudo setfacl -dR -m u:`whoami`:rwX application/
```

## Setup development environment


```bash
./setup.sh
```

This needs to be run only once when you clone the project.

## Build development environment

The application consists of **Docker containers** which are defined by the _docker-compose.yml_ file.

To build the application **tools are needed** like Javascript minifier or SASS compiler, PHPSpec tester or Behat for functional testing. These tools are organized into Docker containers to make these portable and environment independent as much as possible. Furthermore it allows to build only the application itself without requiring to build the tools again.

Every Docker container of the application has a hostname which is actually a FQDN. To get these names resolved to the corresponding IP address, a **DNS server** is added to the application stack. It listens for container IP changes and updates it's internal DNS database based on that.
To get it working, the first nameserver in _/etc/resolv.conf_ have to point to the Docker bridge interface (docker0 currently). The _setup.sh_ script gives help to set it up. Also make sure that the firewall on the host machine allows incoming and outgoing packets from the subnet used by Docker.

### Build the tools

Note: These tools will be built automatically by the `build-*.sh` scripts at the first time.

- __PHP builder__: this Docker container encompasses tools used for building the backend part of the application.
It does statical code validation and veryification, installs 3rd-party dependencies and runs unit test. These are available as Phing tasks, see build.xml file for details.

  Command to build this tool:
  ```bash
  docker build --tag php-builder php-builder/
  ```

- __Javascript compiler__: this Docker container encompasses tools used for building the frontend part of the application.
It installs 3rd-party dependencies, prepares assets which are not provided by Symfony Bundles. These are done by project specific Gulp tasks.

  Command to build this tool:
  ```bash
  docker build --tag js-compiler js-compiler/
  ```

- __BDD tester__: this Docker container encompasses tools used for fuctional testing the application.
It requires a running application to be able to do the testing. Test are run by Behat.

  Command to build this tool:
  ```bash
  docker build --tag bdd-tester bdd-tester/
  ```

### Build the application

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
