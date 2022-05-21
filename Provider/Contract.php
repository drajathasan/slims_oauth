<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-18 12:43:40
 * @modify date 2022-05-21 10:59:54
 * @license GPLv3
 * @desc [description]
 */

namespace SLiMSOAuth\Provider;

abstract class Contract
{
    protected object $accountInfo;
    protected object $client;
    protected string $error = '';
    abstract public function auth();
    abstract public function createIfNotExists();
    abstract public function logout(string $token = '');
    abstract public function getError();
    abstract protected function createSession(Object $Data);
    abstract protected function setCredential();
    abstract public function getAuthUrl();
    abstract public function createButtonAuth(string $url);
}