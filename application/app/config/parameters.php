<?php
$container->setParameter('database_driver', 'pdo_mysql');
$container->setParameter('database_name', getenv('DB_ENV_MYSQL_DATABASE'));
$container->setParameter('database_host', 'db');
$container->setParameter('database_port', getenv('DB_PORT_3306_TCP_PORT'));
$container->setParameter('database_user', getenv('DB_ENV_MYSQL_USER'));
$container->setParameter('database_password', getenv('DB_ENV_MYSQL_PASSWORD'));
