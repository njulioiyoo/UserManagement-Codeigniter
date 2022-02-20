<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClientAPI
 *
 * @author user
 */
class ClientAPI
{
    private $ssoId;
    private $userId;
    private $userName;
    private $appUrl;
    const API_URL_SERVER = "#";
    // const CLIENT_URL="#";
    const CLIENT_URL = "#";
    // const APP_URL="#";
    // const APP_URL="#";
    const APP_URL = "#";
    const SSOID   = 'SSOID';

    public function __construct()
    {

    }

    public function setSsoID($ssoId)
    {
        $this->ssoId = $ssoId;
    }

    public function getSsoID()
    {
        return $this->ssoId;
    }

    public function getUserId()
    {
        return $this->userId;

    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserName()
    {
        return $this->userName;

    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function setAppURL($appUrl)
    {
        $this->appUrl = $appUrl;
    }

    public function getAppURL()
    {
        return $this->appUrl;
    }

    public function retrieveData()
    {

        // CVarDumper::dump($_COOKIE, 10, true);
        // die();

        if (array_key_exists(self::SSOID, $_COOKIE)) {

            if ($_COOKIE[self::SSOID] != null) {
                return $_COOKIE['SSOID'];

            } else {

                header("location:" . self::APP_URL . '');
            }
        } else {
            # echo 'tidak2';

            header("location:" . self::APP_URL . '');exit;
        }
    }

    public function doCurl()
    {
        $ch     = curl_init();
        $cookie = $this->retrieveData();

        $url = $cookie . '/?page=' . self::CLIENT_URL;

        curl_setopt($ch, CURLOPT_URL, self::API_URL_SERVER . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $output = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($output, true);

        if ($result) {

            $arr = (array) $result;
            if ($arr) {
                if ($arr['ISALLOWABLE'] == 1) {

                } else {
                    header("#");
                }
            }
        }
    }
}
