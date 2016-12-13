<?php

require 'AnywhereWrapper.php';

$mail = new AnywhereMail(AnywhereWrapper::POST);

$mail->setTo('diditvelliz@gmail.com');
$mail->setCc('diditvelliz@outlook.com');
$mail->setBcc('vernicariuz@yahoo.co.id');
$mail->setSubject('Anywhere Wrapper');

$mail->setValue('Name', 'Didit Velliz');
$mail->setValue('Age', '22');

$mail->setAttachment('qr.png', 'http://oaas-divelliz.rhcloud.com/qr/render?data=admin@example.co.id');
$mail->setAttachment('qr1.png', 'http://oaas-divelliz.rhcloud.com/qr/render?data=admin@example1.co.id');
$mail->setAttachment('qr2.png', 'http://oaas-divelliz.rhcloud.com/qr/render?data=admin@example2.co.id');
$mail->setAttachment('qr3.png', 'http://oaas-divelliz.rhcloud.com/qr/render?data=admin@example3.co.id');
$mail->setAttachment('qr4.png', 'http://oaas-divelliz.rhcloud.com/qr/render?data=admin@example4.co.id');

$mail->Send('http://oaas-divelliz.rhcloud.com/mail/render/f5d033043cde5da2551ecb1d7fdd9129/3');