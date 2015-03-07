# szepul.hu Setup

Please follow the below steps to get started, if you encounter any issues installing the dependencies or provisioning the vm please check the [Common Issues](#common-issues) section first.

## Clone the project

Clone the project into your local file system:

```bash
git clone git@bitbucket.org:diatigrah/szepulhu.git
```

## Provision Environment

You can now build the development environment for the first time. In the project directory, execute the following command:

```bash
vagrant up
```

When provision is complete you have to add the project's domain to your hosts file:

```bash
echo '192.168.56.101  szepul.hu.dev test.szepul.hu.dev' | sudo tee -a /etc/hosts
```

After that you should be able to access the site at [http://szepul.hu.dev](http://szepul.hu.dev)

## Common Issues

... ?

# License

Copyright 2015, Hargitai Dávid 
