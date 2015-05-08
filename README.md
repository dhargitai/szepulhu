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
sudo setfacl -R -m u:`whoami`:rwX appliction/
sudo setfacl -dR -m u:`whoami`:rwX appliction/
```

## Build development environment

```bash
./build.sh
```

After that you should be able to access the site at http://szepul.hu.dev.

## Common Issues

... ?

# License

Copyright 2015, Búza Géza & Hargitai Dávid 
