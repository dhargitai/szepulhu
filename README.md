# szepul.hu Setup

Please follow the below steps to get started, if you encounter any issues installing the dependencies or provisioning the VM please check the [Common Issues](#common-issues) section first.

## Clone the project

Clone the project into your local file system:

```bash
git clone git@bitbucket.org:diatigrah/szepulhu.git
```

## Initial setup

### Install Vagrant:

Use the package manager of you OS or visit [vagrantup.com](https://www.vagrantup.com/) for install instructions.

### Install Vagrant plugins:

 * Hostsupdater: this is for adding/removing local domain names on VM start and shutdown
 * bindfs: mount the project directory inside the VM with specific user and group ownership 
(change it in *puphet/config.yml* under **sync_owner** and **sync_group** keys)

```bash
vagrant plugin install vagrant-hostsupdater vagrant-bindfs
```

or add the project's domains to your hosts file manually:

```bash
echo '192.168.56.101  szepul.hu.dev test.szepul.hu.dev' | sudo tee -a /etc/hosts
```

## Provision Environment

You can now build the development environment for the first time. In the project directory, execute the following command:

```bash
vagrant up
```

After that you should be able to access the site at [http://szepul.hu.dev](http://szepul.hu.dev)

## Common Issues

... ?

# License

Copyright 2015, Búza Géza & Hargitai Dávid 
