<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-18 12:43:40
 * @modify date 2022-05-19 13:22:35
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
    abstract public function createIfExists();
    abstract public function logout(string $token = '');
    abstract public function getError();
    abstract protected function createSession(Object $Data);
    abstract protected function setCredential();
    abstract public function getAuthUrl();
}