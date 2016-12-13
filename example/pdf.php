<?php

require 'AnywhereWrapper.php';

$pdf = new AnywherePdf(AnywhereWrapper::POST);

$pdf->setValue('Name', 'Didit Velliz');
$pdf->setValue('Age', '22');

$pdf->Send('http://oaas-divelliz.rhcloud.com/pdf/render/f5d033043cde5da2551ecb1d7fdd9129/1');