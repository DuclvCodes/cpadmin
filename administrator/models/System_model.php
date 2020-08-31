<?php

/**
*| --------------------------------------------------------------------------
*| Setting Model
*| --------------------------------------------------------------------------
*| For setting model
*|
*/

class System_model extends MY_Model
{
    public function __construct($server = 'WEB')
    {
        parent::__construct();
        //die('dont want to do this anymore');
        if ($server=='WEB') {
            $this->limit_bw = 100;
            $this->ssh_ip = '123.31.43.211';
            $this->ssh_user = 'root';
            $this->ssh_pass = 'MQknKGENMhqFaXDQHLJ5';
            $this->ssh_port = '2268';
        } else {
            $this->limit_bw = 100;
            $this->ssh_ip = '';
            $this->ssh_user = '';
            $this->ssh_pass = '';
        }
    }
    public function ssh($command)
    {
        $connection = ssh2_connect($this->ssh_ip, $this->ssh_port);
        ssh2_auth_password($connection, $this->ssh_user, $this->ssh_pass);
        if (!$connection) {
            die('Not connect SSH');
        }
        $stream = ssh2_exec($connection, $command);
        ssh2_exec($connection, 'exit');
        stream_set_blocking($stream, true);
        $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
        $res = stream_get_contents($stream_out);
        if ($res=='') {
            $res = 'Success';
        }
        return $res;
    }
    public function sendFile($local, $remote)
    {
        $connection = ssh2_connect($this->ssh_ip, $this->ssh_port);
        ssh2_auth_password($connection, $this->ssh_user, $this->ssh_pass);
        if (!$connection) {
            die('Not connect SSH');
        }
        $res = ssh2_scp_send($connection, $local, $remote, 0644);
        ssh2_exec($connection, 'exit');
        return $res;
    }
    public function recvFile($remote, $local)
    {
        $connection = ssh2_connect($this->ssh_ip, 22);
        ssh2_auth_password($connection, $this->ssh_user, $this->ssh_pass);
        if (!$connection) {
            die('Not connect SSH');
        }
        $res = ssh2_scp_recv($connection, $remote, $local);
        ssh2_exec($connection, 'exit');
        return $res;
    }
    public function getInfoServer()
    {
        $key = MEMCACHE_NAME.'SYSINFO'.$this->ssh_ip;
        $sysinfo = $this->getCache($key);
        if (!$sysinfo) {
            $cpu = trim($this->ssh('cat /proc/cpuinfo | grep "^processor" | wc -l'), "\n");
            $ram = array_shift(explode(' ', trim(ltrim($this->ssh('free -m | grep "Mem"'), 'Mem:')), 2));
            $shell = 'df -h';
            $partition = $this->hdd_partition;
            if ($partition) {
                $shell .= ' | grep "'.$partition.'"';
            } else {
                $shell .= ' | head -2';
            }
            if ($partition=='/home') {
                $hdd = $this->ssh($shell.' | awk \'{ printf "%s", $1}\'');
            } else {
                $hdd = $this->ssh($shell.' | awk \'{ printf "%s", $2}\'');
            }
            $sysinfo = json_encode(array($cpu, $ram, $hdd));
            $Cache->set($key, $sysinfo, MEMCACHE_COMPRESSED, 0);
        }
        $sysinfo = json_decode($sysinfo);
        return $sysinfo;
    }
    public function getHDD($is_percent=1)
    {
        $key = 'SYSHDD'.$is_percent.$this->ssh_ip;
        $hdd_usage = $this->getCache->get($key);
        if (!$hdd_usage) {
            $shell = 'df -h';
            $partition = $this->hdd_partition;
            if ($partition) {
                $shell .= ' | grep "'.$partition.'"';
            } else {
                $shell .= ' | head -2';
            }
            $col = 3;
            if ($is_percent) {
                $col = 5;
            }
            if ($partition=='/home') {
                $col--;
            }
            $hdd_usage = $this->ssh($shell.' | awk \'{ printf "%s", $'.$col.'}\'');
            $Cache->set($key, $hdd_usage, 0, 60*60);
        }
        return $hdd_usage;
    }
    public function getCPU()
    {
        return $this->ssh("top -b -n2 -d.2 | grep 'Cpu(s)'| tail -n 1 | awk '{printf $2 + 0}'");
    }
    public function getRAM()
    {
        return $this->ssh("free | grep Mem | awk '{printf($3/$2 * 100)}'");
    }
    public function getBandwidth()
    {
        $key = 'tkp_BW'.$this->ssh_ip;
        $PREV = $this->getCache($key);
        if ($PREV) {
            $arr = explode('|', $PREV);
            $time_prev = $arr[0];
            $total_prev = $arr[1];
        } else {
            $RX = $this->ssh('cat /sys/class/net/eth0/statistics/rx_bytes');
            $TX = $this->ssh('cat /sys/class/net/eth0/statistics/tx_bytes');
            $total_prev = (intval($RX)+intval($TX));
            $time_prev = time();
            sleep(3);
        }
        $time = time();
        $RX = $this->ssh('cat /sys/class/net/eth0/statistics/rx_bytes');
        $TX = $this->ssh('cat /sys/class/net/eth0/statistics/tx_bytes');
        $TOTAL = (intval($RX)+intval($TX));
        $Cache->set($key, $time.'|'.$TOTAL, false, 60);
        return round((($TOTAL-$total_prev)*8/1024/1024)/($time-$time_prev), 2);
    }
    public function IEC2Bytes($str)
    {
        $str = trim($str);
        $arr = explode(' ', $str);
        if ($arr) {
            $unit = $arr[1];
            $value = $arr[0];
            if ($unit=='KiB') {
                return $value*1024;
            } elseif ($unit=='MiB') {
                return $value*1024*1024;
            } elseif ($unit=='GiB') {
                return $value*1024*1024*1024;
            } elseif ($unit=='TiB') {
                return $value*1024*1024*1024*1024;
            } else {
                return 0;
            }
        } else {
            return false;
        }
    }
}
