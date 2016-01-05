<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class IosPushHelper {

    public static function sendNotification($device_token, $message) {
        $passphrase = '  ';
        //  echo  dirname(__FILE__) . 'PushNotificationMeboo.pem';  die;
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', dirname(__FILE__) . '/PushNotificationMeboo.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp) {
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        }

        //    echo 'Connected to APNS' . PHP_EOL;
// Create the payload body
        $body['aps'] = $message;

// Encode the payload as JSON
        $payload = json_encode($body);

// Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;

// Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        if (!$result) {
            //   echo 'Message not delivered' . PHP_EOL;
        } else {
            //   echo 'Message successfully delivered' . PHP_EOL;
        }

// Close the connection to the server
        fclose($fp);
    }

}
