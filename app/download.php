<?php

$AppSettingFile = file_get_contents('assets/app_settings.json');
$data = json_decode($AppSettingFile);

$maintenance = $data->maintenance;

if (!$maintenance) {

    $latest_version = $data->latest_version;
    $file = 'apk/CLHear TApp (v.' . $latest_version . ').apk';

    if (file_exists($file)) {

        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d H:i:s");

        $file_dir = "../assets/download_logs.json";

        $DownlodLogs = file_get_contents($file_dir);
        $dl_data = json_decode($DownlodLogs, true);


        $dl_data['count_download'] = $dl_data["count_download"] + 1;
        $dl_data['last_download'] = $date;

        $newJsonString = json_encode($dl_data);
        file_put_contents($file_dir, $newJsonString);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    } else {
        header("HTTP/1.1 404 Not Found");
    }
} else {
    header("HTTP/1.1 500 Internal Server Error");
}
