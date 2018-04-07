<?php
/**
 * Created by PhpStorm.
 * User: mantas
 * Date: 07/04/2018
 * Time: 16:54
 */
namespace FtpClient;
//bye             užbaigti ftp sesiją +
//cd              pakeisti dabartinę direktoriją serveryje +
//chmod           pakeisti serveryje esančio failo teises +
//delete          ištrinti failą serveryje -
//get             inicijuoti failo siuntimą iš serverio -
//help            rodyti pagalbą -
//ls              rodyti esamosios serverio direktorijos turinį +
//mode            pakeisti failų siuntimo režimą -
//mput            siųsti į serverį keletą failų -
//put             siųsti į serverį failą -
//pwd             rodyti serverio dabartinę direktoriją +
//recv            inicijuoti failo siuntimą iš serverio -
//rename          pervadinti failą serveryje +
//rmdir           ištrinti direktoriją serveryje +

class Action
{
    private $connectionId;
    private $directory = "~";
    private $commandsList = [
        ["command" => "bye", "info" => " - \e[33mto quit from FTP server\e[30m,\n"], //+
        ["command" => "cd", "info" => " - \e[33mchange direcotory to [cd test]\e[30m,\n"], //+
        ["command" => "chmod", "info" => " - \e[33madd permissions [chmod 0777 test.txt]\e[30m,\n"], //+
        ["command" => "delete", "info" => " - \e[33mdelete file [delete test.txt]\e[30m,\n"], //+
        ["command" => "get", "info" => " - \e[33mdownload file [get test.txt]\e[30m,\n"], //+
        ["command" => "help", "info" => " - \e[33mhelp\e[30m,\n"], //+
        ["command" => "ls", "info" => " - \e[33mshow all directories and files in current directory\e[30m,\n"], //+
        ["command" => "mode", "info" => " - \e[33mmode\e[30m,\n"], //-
        ["command" => "mput", "info" => " - \e[33mmput\e[30m,\n"], //-
        ["command" => "put", "info" => " - \e[33mupload file to server from file directory [put test.txt]\e[30m,\n"], //+
        ["command" => "pwd", "info" => " - \e[33mshow current directory\e[30m,\n"], //+
        ["command" => "rename", "info" => " - \e[33mrename file [rename test.txt test2.txt]\e[30m,\n"], //+
        ["command" => "rmdir", "info" => " - \e[33mremove directory [rmdir test]\e[30m,\n"], //+
        ["command" => "mkdir", "info" => " - \e[33mmake directory [mkdir test]\e[30m,\n"], //+
        ["command" => "size", "info" => " - \e[33mshow size of file [size test.txt]\e[30m\n"], //+
    ];
    private $foreground_colors = array();

    public function __construct($connectionId)
    {
        // Set up shell colors
        $this->foreground_colors['black'] = '0;30m';
        $this->foreground_colors['dark_gray'] = '1;30';
        $this->foreground_colors['blue'] = '0;34';
        $this->foreground_colors['light_blue'] = '1;34';
        $this->foreground_colors['green'] = '0;32';
        $this->foreground_colors['light_green'] = '1;32';
        $this->foreground_colors['cyan'] = '0;36';
        $this->foreground_colors['light_cyan'] = '1;36';
        $this->foreground_colors['red'] = '0;31';
        $this->foreground_colors['light_red'] = '1;31';
        $this->foreground_colors['purple'] = '0;35';
        $this->foreground_colors['light_purple'] = '1;35';
        $this->foreground_colors['brown'] = '0;33';
        $this->foreground_colors['yellow'] = '1;33m';
        $this->foreground_colors['light_gray'] = '0;37';
        $this->foreground_colors['white'] = '1;37';

        $this->connectionId = $connectionId;
    }


    public function run(){ //+
        printf("\033[33mWelcome to FTP SERVER!\033[30m\n\n");
    }

    public function size($file){
        $res = ftp_size($this->connectionId, $file);

        if ($res != -1) {
            echo "Size of $file is $res bytes\n";
        } else {
            echo "Couldn't get the size\n";
        }
    }

    public function get($file){
        $downlDir = "/Users/mantas/Desktop/FTPClientPHP/downloaded/";
        if(file_exists($downlDir.$file)){
            unlink($downlDir.$file);
        }
        if (ftp_get($this->connectionId, $file, $file, FTP_BINARY)) {
            echo "\e[32mSuccessfully written to $file to downloaded directory\e[30m\n";
            copy($file, 'downloaded/'.$file);
            unlink($file);
        } else {
            echo "\e[31mThere was a problem\e[30m\n";
        }
    }

    public function help(){ //+
        printf("\n\e[31mCommands list: \n\n");
        foreach($this->commandsList as $item){
            printf("\e[32m".$item['command'].$item['info']);
        }
        printf("\n\n");
    }

    public function listen(){ //+
        $directory = ftp_pwd($this->connectionId);
        return readline("\e[34mServer:".$directory." Client$ \e[30m");
    }

    public function rmdir($dir){ //+
        if (ftp_rmdir($this->connectionId, $dir)) {
            echo "\e[32mSuccessfully deleted $dir\e[30m\n";
        } else {
            echo "\e[31mThere was a problem while deleting $dir\e[30m\n";
        }
    }

    public function mkdir($dir){ //+
        if (ftp_mkdir($this->connectionId, $dir)) {
            echo "\e[32mSuccessfully created $dir\e[30m\n";
        } else {
            echo "\e[31mThere was a problem while creating $dir\e[30m\n";
        }
    }

    public function put($file){ //+
        if (ftp_put($this->connectionId, $file, "files/".$file, FTP_ASCII)) {
            echo "\e[32mSuccessfully uploaded $file\e[30m\n";
        } else {
            echo "\e[31mThere was a problem while uploading $file\e[30m\n";
        }
    }

    public function chmod($mode, $file){ //+
        ftp_chmod($this->connectionId, $mode, $file);
    }

    public function delete($file){ //+
        if (ftp_delete($this->connectionId, $file)) {
            echo "\e[32m$file deleted successful\e[30m\n";
        } else {
            echo "\e[31mcould not delete $file\e[30m\n";
        }

    }

    public function rename($oldFile, $newFile){ //+
        if (ftp_rename($this->connectionId, $oldFile, $newFile)) {
            echo "\e[32mSuccessfully renamed $oldFile to $newFile\e[30m\n";
        } else {
            echo "\e[31mThere was a problem while renaming $oldFile to $newFile\e[30m\n";
        }

    }

    public function ls(){ //+
        $contents = ftp_nlist($this->connectionId, ".");
        printf("\e[33mDirectories list\e[30m\n\n");
        printf("\e[34mTotal: ".count($contents)."\e[30m\n");
        $i = 1;
        foreach ($contents as $directory){
            printf($i.". \e[32m".$directory."\e[30m\n");
            $i++;
        }
    }
    public function pwd(){ //+
        $directory = ftp_pwd($this->connectionId);
        printf("\e[32m".$directory . "\e[30m\n");
        return $directory;
    }

    public function cd($directory){ //+
        if (ftp_chdir($this->connectionId, $directory)) {
            if ($this->directory = "~"){
                $this->directory = "";
            }
        } else {
            echo "\e[31mCouldn't change directory\e[30m\n";
        }
    }

    public function getAllAfterSpace($command){
        return substr($command, strpos($command, " ")+1, strlen($command));
    }

    public function getCommand($command){
        return substr($command, 0, strpos($command, " "));
    }
}