<?php
/**
 * Created by PhpStorm.
 * User: mantas
 * Date: 07/04/2018
 * Time: 17:14
 */

namespace FtpClient;

use Symfony\Component\Yaml\Yaml;

class Security
{
    private $connectionId;
    private $loginResult;

    public function connect(){
        $parameters = $this->fetchParameters();
        $this->connectionId = ftp_connect($parameters['security']['host']);
        $this->loginResult = ftp_login($this->connectionId, $parameters['security']['username'], $parameters['security']['password']);
    }

    public function closeConnection(){
        ftp_close($this->connectionId);
    }

    public function fetchParameters(){
        return Yaml::parse(file_get_contents('/Users/mantas/Desktop/FTPClientPHP/parameters.yml'));
    }

    public function getConnectionId(){
        return $this->connectionId;
    }

    public function getLoginResult(){
        return $this->loginResult;
    }

}