#!/bin/bash
#clear
function start_server()
{
    response=$(check_process server.js)

	if [ "${response}" != "0" ]; then
   		cd ~/medlib
   		node server.js &
   		cd -
   	fi
}

function start_maildev()
{
    response=$(check_process maildev)

    if [ "${response}" != "0" ]; then
   		maildev > /dev/null 1>&2
   	fi
}


function check_process()
{
    local process=`ps aux | grep -v grep | grep -i $1 | awk {'print $2'}`

    if [ -n "$process" ]; then
        echo 0
    else
        echo 2
    fi
}

start_maildev && start_server &
