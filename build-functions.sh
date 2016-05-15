#!/usr/bin/env bash

: '
This file is part of the szepul.hu application.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
'

function is_container_exists {
    container_name=$1
    ! [ -z $(docker ps -a -q --filter="name=$container_name") ]
}

function is_image_exists {
    image_name=$1
    ! [ -z $(docker images -q "$image_name") ]
}

function is_container_running {
    container_name=$1
    ! [ -z $(docker ps -q --filter="name=$container_name") ]
}