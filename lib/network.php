<?php

namespace lib;

class Network {

    public static function connections() {
        global $ssh;
        $connections = $ssh->shell_exec_noauth("netstat -nta --inet | wc -l");
        $connections--;

        return array(
            'connections' => substr($connections, 0, -1),
            'alert' => ($connections >= 50 ? 'warning' : 'success')
        );
    }

    public static function ethernet() {
        global $ssh;
        //$data = $ssh->shell_exec_noauth("/sbin/ifconfig eth0 | grep RX\ bytes");
        $dataRX = $ssh->shell_exec_noauth("</proc/net/dev grep -oP 'eth0'':\s*\K\d+'");
        $dataRX = str_ireplace("RX bytes:", "", $dataRX);
        $dataTX = $ssh->shell_exec_noauth("</proc/net/dev grep -oP 'eth0'':\s*(\d+\s+){1}\K\d+'");
        $dataTX = str_ireplace("TX bytes:", "", $dataTX);
        //$data = str_ireplace("RX bytes:", "", $data);
        //$data = str_ireplace("TX bytes:", "", $data);
        $dataRX = trim($dataRX);
        $dataTX = trim($dataTX);
        $dataRX = explode(" ", $dataRX);
        $dataTX = explode(" ", $dataTX);

        $rxRaw = $dataRX[0] / 1024 / 1024;
        $txRaw = $dataTX[0] / 1024 / 1024;
        $rx = round($rxRaw, 2);
        $tx = round($txRaw, 2);

        return array(
            'up' => $tx,
            'down' => $rx,
            'total' => $rx + $tx
        );
    }

}
