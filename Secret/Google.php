<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-18 08:39:51
 * @modify date 2022-05-20 14:37:26
 * @license GPLv3
 * @desc [description]
 */

namespace SLiMSOAuth\Secret;

use PDO;
use SLiMS\DB;

trait Google
{
    protected function setCredential()
    {
        $config = getSLiMSOAuthConfig();
        $this->client->setClientId($config['ClientId']??'');
        $this->client->setClientSecret($config['ClientSecret']??'');
        $this->client->setRedirectUri($config['RedirectUrl']??'');
        $this->client->addScope("email");
        $this->client->addScope("profile");
    }
}
