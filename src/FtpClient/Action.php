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
        ["command" => "bye", "info" => " - to quit from FTP server,\n"], //+
        ["command" => "cd", "info" => " - cd,\n"], //+
        ["command" => "chmod", "info" => " - chmod,\n"], //+
        ["command" => "delete", "info" => " - delete,\n"], //+
        ["command" => "get", "info" => " - get,\n"], //-
        ["command" => "help", "info" => " - help,\n"], //+
        ["command" => "ls", "info" => " - ls,\n"], //+
        ["command" => "mode", "info" => " - mode,\n"], //-
        ["command" => "mput", "info" => " - mput,\n"], //-
        ["command" => "put", "info" => " - put,\n"], //+
        ["command" => "pwd", "info" => " - pwd,\n"], //+
        ["command" => "get", "info" => " - get,\n"],
        ["command" => "rename", "info" => " - rename,\n"],
        ["command" => "rmdir", "info" => " - rmdir,\n"],
        ["command" => "send", "info" => " - send,\n"],
        ["command" => "mkdir", "info" => " - mkdir,\n"],
        ["command" => "size", "info" => " - show size of file\n"],
    ];

    public function __construct($connectionId)
    {
        $this->connectionId = $connectionId;
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
        if (ftp_get($this->connectionId, $file, $file, FTP_BINARY)) {
            echo "Successfully written to $file to downloaded directory\n";
            copy($file, 'downloaded/'.$file);
            unlink($file);
        } else {
            echo "There was a problem\n";
        }
    }

    public function help(){ //+
        printf("\nCommands list: \n\n");
        foreach($this->commandsList as $item){
            printf($item['command'].$item['info']);
        }
        printf("\n\n");
    }

    public function listen(){ //+
        $directory = ftp_pwd($this->connectionId);
        return readline("Server:".$directory." Client$ ");
    }

    public function run(){ //+
        printf("Welcome to FTP SERVER!\n\n");
    }

    public function rmdir($dir){ //+
        if (ftp_rmdir($this->connectionId, $dir)) {
            echo "Successfully deleted $dir\n";
        } else {
            echo "There was a problem while deleting $dir\n";
        }
    }

    public function mkdir($dir){ //+
        if (ftp_mkdir($this->connectionId, $dir)) {
            echo "Successfully created $dir\n";
        } else {
            echo "There was a problem while creating $dir\n";
        }
    }

    public function put($file){ //+
        if (ftp_put($this->connectionId, $file, "files/".$file, FTP_ASCII)) {
            echo "Successfully uploaded $file\n";
        } else {
            echo "There was a problem while uploading $file\n";
        }
    }

    public function chmod($mode, $file){ //+
        ftp_chmod($this->connectionId, $mode, $file);
    }

    public function delete($file){ //+
        if (ftp_delete($this->connectionId, $file)) {
            echo "$file deleted successful\n";
        } else {
            echo "could not delete $file\n";
        }

    }

    public function rename($oldFile, $newFile){ //+
        if (ftp_rename($this->connectionId, $oldFile, $newFile)) {
            echo "successfully renamed $oldFile to $newFile\n";
        } else {
            echo "There was a problem while renaming $oldFile to $newFile\n";
        }

    }

    public function ls(){ //+
        $contents = ftp_nlist($this->connectionId, ".");
        printf("Directories list\n\n");
        printf("Total: ".count($contents)."\n");
        $i = 1;
        foreach ($contents as $directory){
            printf($i.". ".$directory."\n");
            $i++;
        }
    }
    public function pwd(){ //+
        $directory = ftp_pwd($this->connectionId);
        printf($directory . "\n");
        return $directory;
    }

    public function cd($directory){ //+
        if (ftp_chdir($this->connectionId, $directory)) {
            if ($this->directory = "~"){
                $this->directory = "";
            }
        } else {
            echo "Couldn't change directory\n";
        }
    }

    public function getAllAfterSpace($command){
        return substr($command, strpos($command, " ")+1, strlen($command));
    }

    public function getCommand($command){
        return substr($command, 0, strpos($command, " "));
    }
}