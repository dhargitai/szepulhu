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

#### Bower issue
You may have an error while bower tries to install its dependencies:
```console
Failed to execute "git ls-remote --tags --heads git://github.com/jquery/jquery.git", exit code of #128
fatal: unable to connect to github.com:
github.com[0: 192.30.252.131]: errno=Connection refused
```

**Solution:** Run the following command on host:
```console
git config --global url."https://".insteadOf git://
```


# License

Copyright 2015, Búza Géza & Hargitai Dávid 
