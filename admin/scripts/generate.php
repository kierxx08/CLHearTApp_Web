<?php

function gen_announce_id($conn)
{
    $i = 1;
    while ($i == 1) {
        $id = "A-";
        $id .= str_pad(rand(0, 999999), 6, 0, STR_PAD_LEFT);
        $query = mysqli_query($conn, "SELECT * FROM `announcement` WHERE announce_id='$id'");
        if (mysqli_num_rows($query) == 1) {
            $i = 1;
        } else {
            $i = 0;
        }
    }

    return $id;
}

function gen_res_id($conn)
{
    $i = 1;
    while ($i == 1) {
        $id = "RES-";
        $id .= str_pad(rand(0, 999999), 6, 0, STR_PAD_LEFT);
        $query = mysqli_query($conn, "SELECT * FROM `resources_info` WHERE res_id='$id'");
        if (mysqli_num_rows($query) == 1) {
            $i = 1;
        } else {
            $i = 0;
        }
    }

    return $id;
}

function gen_tag($conn, $value)
{
    $sql = "INSERT INTO `tag_info`( `tag_name`) VALUES ('$value')";
    if (mysqli_query($conn,$sql)) {
        return true;
    } else {
        return false;
    }
}

function qr_encrypt($text)
{

    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    $encryption_iv = '1234567891011121';
    $encryption_key = "QRS3XR3TP@$$";

    $encryption = openssl_encrypt(
        $text,
        $ciphering,
        $encryption_key,
        $options,
        $encryption_iv
    );

    return $encryption;
}

function password_encrypt($password)
{

    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    $encryption_iv = '1234567891011121';
    $encryption_key = "S3XR3TP@$$";

    $encryption = openssl_encrypt(
        $password,
        $ciphering,
        $encryption_key,
        $options,
        $encryption_iv
    );

    return $encryption;
}

function random_str(
    int $length,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {

    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }

    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;

    for ($i = 0; $i < $length; ++$i) {
        $pieces[] = $keyspace[random_int(0, $max)];
    }

    return implode('', $pieces);
}
