# Raspcontrol

Raspcontrol is a web control centre written in PHP for Raspberry Pi.

This is a Fork of Forked Raspcontrol by harmon25 (It appears some functionalities in the fork are not working).
Original RaspControl by Bioshox (It appears the repo is no longer available).


***


## Installation (Pre-req)

You need a web server installed on your Raspberry Pi (Apache2, lighttpd or php)

### sudo apt-get install php-fpm
### sudo apt-get install apache2
### sudo apt-get install lighttpd

Create the json authentifation file `/etc/raspcontrol/database.aptmnt`:
	{
 	   "user":       "yourName",
 	   "password":   "yourPassword"
	}

file `/etc/raspcontrol/database.aptmnt` should be owned by user with root access and chmod 755

### sudo chmod 755 /etc/raspcontrol/database.aptmnt
### sudo chown /etc/raspcontrol/database.aptmnt user  ?? user = user on pi with root access

## Running

Tested in following environments:
1. sudo apt-get install php-fpm
2. cd /var/www/
3. git clone https://github.com/harmon25/raspcontrol.git
4. cd raspcontrol
5. php -S 0.0.0.0:8000
6. Access the webpage through http://localhost:8000 or http://local-ip-of-pi:8000

## Optional configuration

In order to have some beautiful URLs, you can enable URL Rewriting.  
__Note:__ It's not necessary to enable URL Rewriting to use Raspcontrol.

## Known Issues
Internal IP is not shown on home and details page.
Services all show stopped, which is wrong.
GPIO page is not displaying correct info.


## Changes from the forked git

/lib/memory.php
	Line 17 and 41 => free -m
	Line 29 and 30 => 
		$result['free'] = $total - $user - $shared;
        		$result['used'] = $used + $shared;

	Line 23 => $result['percentage'] = round(($used + $shared) / $total * 100);

/pages/details.php
 	Line 133 => ?>°C</span>

/lib/network.php
	Line 19 =>
 		global $ssh;
        $dataRX = $ssh->shell_exec_noauth("</proc/net/dev grep -oP 'eth0'':\s*\K\d+'");
        $dataRX = str_ireplace("RX bytes:", "", $dataRX);
        $dataTX = $ssh->shell_exec_noauth("</proc/net/dev grep -oP 'eth0'':\s*(\d+\s+){1}\K\d+'");
        $dataTX = str_ireplace("TX bytes:", "", $dataTX);
        $dataRX = trim($dataRX);
        $dataTX = trim($dataTX);
        $dataRX = explode(" ", $dataRX);
        $dataTX = explode(" ", $dataTX);

        $rxRaw = $dataRX[0] / 1024 / 1024;
        $txRaw = $dataTX[0] / 1024 / 1024;
        $rx = round($rxRaw, 2);
        $tx = round($txRaw, 2);

Copied file /css/images/ui-bg_flat_75_ffffff_40x100.png

## References:
https://elinux.org/Raspcontrol

Original Git: https://github.com/Bioshox/Raspcontrol

Forked Git: https://github.com/harmon25/raspcontrol 

RX/TX data issue: https://askubuntu.com/a/1094606 

Missing image in css/images: https://github.com/julienw/jquery-trap-input/tree/master/lib/jquery/themes/base/images 

Raspcontrol info: https://developer-blog.net/en/raspcontrol-a-web-interface-with-your-raspberry-pi-stats/ 