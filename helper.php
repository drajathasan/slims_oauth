<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-18 07:47:29
 * @modify date 2022-05-20 12:45:36
 * @license GPLv3
 * @desc [description]
 */

if (!function_exists('assetsPath'))
{
    /**
     * Retrieve plugin url link 
     *
     * @param string $additionalPath
     * @return string
     */
    function assetsUrl(string $additionalPath)
    {
        $pluginDirectory = basename(__DIR__);
        return SWB . 'plugins/' . $pluginDirectory . '/assets/' . $additionalPath;
    }
}

if (!function_exists('pluginDir'))
{
    /**
     * Retrieve plugin path directory
     *
     * @param string $additionalPath
     * @return string
     */
    function pluginDir(string $additionalDirPath)
    {
        $pluginDirectory = basename(__DIR__);
        return SB . 'plugins/' . $pluginDirectory . DS . $additionalDirPath;
    }
}

if (!function_exists('downloadImage'))
{
    /**
     * Download user image after 
     * OAuth login success
     *
     * @param string $url
     * @param string $pathToSave
     * @return void
     */
    function downloadImage(string $url, string $pathToSave)
    {
        $client = new \GuzzleHttp\Client;
        $client->request('GET', $url, ['sink' => $pathToSave]);
    }
}

if (!function_exists('getSLiMSOAuthConfig'))
{
    /**
     * Getter for plugin configuration
     *
     * @return void
     */
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

if (!function_exists('isHttps'))
{
    /**
     * This plugin need HTTPS connection,
     * Https checker is need to make sure
     * it running on HTTPS or not 
     *
     * @return boolean
     */
    function isHttps()
    {
        $url = parse_url($_SERVER['HTTP_REFERER']);

        return $url['scheme'] === 'https';
    }
}