# **************************************************************************** #
#                                                                              #
#                                                         :::      ::::::::    #
#    create.sh                                          :+:      :+:    :+:    #
#                                                     +:+ +:+         +:+      #
#    By: akaplyar <akaplyar@student.unit.ua>        +#+  +:+       +#+         #
#                                                 +#+#+#+#+#+   +#+            #
#    Created: 2017/10/19 15:00:02 by akaplyar          #+#    #+#              #
#    Updated: 2017/10/24 15:02:55 by akaplyar         ###   ########.fr        #
#                                                                              #
# **************************************************************************** #

#!/bin/bash

if [ -n "$1" ] && [ -n "$2" ]
then
    echo "DROP DATABASE IF EXISTS camagru;CREATE DATABASE camagru;" > temp
    $HOME/Library/Containers/MAMP/mysql/bin/mysql -u$1 -p$2 < temp
    rm -rf temp
else
    exit 1
fi
