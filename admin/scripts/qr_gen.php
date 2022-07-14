<?php
require_once '../assets/qrcode-monkey/autoload.php';

use nguyenary\QRCodeMonkey\QRCode;

include('generate.php');

if (isset($_GET['red_id'])) {

    $res_id = $_GET['red_id'];

    $qrcode = new QRCode(qr_encrypt($res_id));

    $qrcode->setConfig([
        'bgColor' => '#FFFFFF',
        'body' => 'circle',
        'bodyColor' => '#345394',
        'brf1' => [],
        'brf2' => [],
        'brf3' => [],
        'erf1' => [],
        'erf2' => [],
        'erf3' => [],
        'eye' => 'frame13',
        'eye1Color' => '#345394',
        'eye2Color' => '#345394',
        'eye3Color' => '#345394',
        'eyeBall' => 'ball15',
        'eyeBall1Color' => '#345394',
        'eyeBall2Color' => '#345394',
        'eyeBall3Color' => '#345394',
        'gradientColor1' => '',
        'gradientColor2' => '',
        'gradientOnEyes' => 'false',
        'gradientType' => 'linear',
    ]);

    $qrcode->setLogo('../../image/qrcode_logo.png');
    $qrcode->setFileType('png');
    $qrcode->setSize(200);

    $qrcode->create('../../image/resources_qrcode/' . $res_id . '.png');
} else {
    echo 'Error';
}
