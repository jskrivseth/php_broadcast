<?php

$ip = "0.0.0.0";
$port = 8888;
$max_msg_len = 65535;

//keep track of IPs and the last time they reported in
$active_ips = [];

echo "starting...";

//Reduce errors
error_reporting(~E_WARNING);

function bind_socket($sock, $ip, $port)
{
// Bind the source address
    if (!socket_bind($sock, $ip, $port)) {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        die("Could not bind socket : [$errorcode] $errormsg \n");
    }
    return true;
}

function open_socket()
{
//Create a UDP socket
    if (!($sock = socket_create(AF_INET, SOCK_DGRAM, 0))) {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        die("Couldn't create socket: [$errorcode] $errormsg \n");
    }
    return $sock;
}

//create a socket
$sock = open_socket();
//bind the socket to the ip/port
bind_socket($sock, $ip, $port);

//wait for messages
while (true) {
    //block until data is received
    socket_recvfrom($sock, $buf, $max_msg_len, 0, $ip, $port);
    echo "Message from $ip:$port" . PHP_EOL;
    echo "$buf" . PHP_EOL;
    //keep track of the last time each $ip reported in
    $active_ips[$ip]['last_ping'] = gmdate('Y-m-d H:i:s');
    var_dump($active_ips);
}
socket_close($sock);
