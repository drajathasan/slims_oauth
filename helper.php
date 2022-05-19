<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-18 07:47:29
 * @modify date 2022-05-19 16:11:52
 * @license GPLv3
 * @desc [description]
 */

if (!function_exists('assetsPath'))
{
    function assetsUrl(string $additionalPath)
    {
        $pluginDirectory = basename(__DIR__);
        return SWB . 'plugins/' . $pluginDirectory . '/assets/' . $additionalPath;
    }
}

if (!function_exists('downloadImage'))
{
    function downloadImage(string $url, string $pathToSave)
    {
        $client = new \GuzzleHttp\Client;
        $client->request('GET', $url, ['sink' => $pathToSave]);
    }
}

if (!function_exists('getSLiMSOAuthConfig'))
{
    function getSLiMSOAuthConfig()
    {
        $db = \SLiMS\DB::getInstance();
        $configState = $db->query("select setting_value from setting where setting_name = 'oauth_provider'");

        if ($configState->rowCount())
        {
            $data = $configState->fetch(PDO::FETCH_OBJ);
            return @unserialize($data->setting_value);
        }
    }
}