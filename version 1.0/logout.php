<?php
class myftp {
var $connector;
var $getback;
function connect($ftp_server, $uname, $passwd){
$this->connector = @ftp_connect($ftp_server);
$this->login_result = @ftp_login($this->connector, "$uname", "$passwd");
		if ((!$this->connector)||(!$this->login_result))
		{
			echo "FTP connection has failed! \n";
			echo "Attempted to connect to $ftp_server for user $uname \n";
			die;
		} else {
			echo "Connected to $ftp_server, for user $uname \n";
		}
    }
    function lastmodtime($value){
        $getback = ftp_mdtm ($this->connector,$value);
        return $getback;
    }
    function changedir($targetdir){
        $getback = ftp_chdir($this->connector, $targetdir);
        return $getback;
    }
    function getdir(){
        $getback = ftp_pwd($this->connector);
        return $getback;
    }
    function get_file_list(){
		putenv('TMPDIR=/tmp/');
		$file_list = ftp_nlist($this->connector, "");
		echo "</br>";
		foreach ($file_list as $file)
		{
			if (ftp_get($this->connector, "/Applications/XAMPP/xamppfiles/htdocs/hw2/$file", $file, FTP_BINARY)) {
   			 	echo "Successfully written";
				 $delstatus = ftp_delete($this->connector, $file);
			} else {
				echo "There was a problem ";
			}
			echo "</br>";
		}
		
    }
    function get_file($file_to_get, $mode, $mode2){
        $realfile = basename($file_to_get);
        $filename = $realfile;
        $checkdir = @$this->changedir($realfile);
        if ($checkdir == TRUE){
            ftp_cdup($this->connector);
            echo "\n[DIR] $realfile";
        }else{
            echo "..... ". $realfile ."\n";
            $getback = ftp_get($this->connector, $filename, $realfile, $mode);
            if ($mode2){
                $delstatus = ftp_delete($this->connector, $file_to_get);
                if ($delstatus == TRUE){
                    echo "File $realfile on $host deleted \n";
                }
            }
        }
        return $getback;
    }
    function mode($pasvmode){
        $result = ftp_pasv($this->connector, $pasvmode);
    }
    function ftp_bye(){
        ftp_quit($this->connector);
        return $getback;
    }
}
$ftp=new myftp;
$ftp->connect("ripitvids.com", "zhongzheng@rcptherapy.com","910423Ok");

$ftp->get_file_list();

?>