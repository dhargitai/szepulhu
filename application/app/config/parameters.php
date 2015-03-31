<?php
$container->setParameter('database_driver', 'pdo_mysql');
$container->setParameter('database_name', getenv('DB_ENV_MYSQL_DATABASE'));
$container->setParameter('database_host', getenv('DB_1_PORT_3306_TCP_ADDR'));
$container->setParameter('database_port', getenv('DB_1_PORT_3306_TCP_PORT'));
$container->setParameter('database_user', getenv('DB_1_ENV_MYSQL_USER'));
$container->setParameter('database_password', getenv('DB_1_ENV_MYSQL_PASSWORD'));
