<?php
$deviceToken = '5cb40af6e6d086c802735c0c6a489c6bbb03b4e2f6b787da9e1d83303a793175';
$passphrase = 'cx925ll';
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
$fp = stream_socket_client(
            'ssl://gateway.sandbox.push.apple.com:2195', $err,
              $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
 
if (!$fp)
  exit("Failed to connect: $err $errstr" . PHP_EOL);
 
echo 'Connected to APNS' . PHP_EOL;
$body['aps'] = array(
          'alert' => 'PushNotification is Successed!',
          'sound' => 'default'
             );
$payload = json_encode($body);
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
$result = fwrite($fp, $msg, strlen($msg));
if (!$result)
  echo 'Message not delivered' . PHP_EOL;
else
  echo 'Message successfully delivered' . PHP_EOL;
fclose($fp);