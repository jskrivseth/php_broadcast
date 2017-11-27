<?php

//broadcast only on the local subnet - will not be routed
$ip = "255.255.255.255";
$port = 8888;
$json_msg = "{type: \"broadcast\",message: \"DEVICE_HEARTBEAT\"}";

$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

$msg = $json_msg;
$len = strlen($msg);

socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, 1);

//send a message every second
while (true) {
    echo ".";
    socket_sendto($sock, $msg, $len, 0, $ip, $port);
    sleep(1);
}

socket_close($sock);
