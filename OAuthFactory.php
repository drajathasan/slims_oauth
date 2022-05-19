<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-18 14:42:27
 * @modify date 2022-05-19 14:17:17
 * @license GPLv3
 * @desc [description]
 */

namespace SLiMSOAuth;

use Exception,Closure,ReflectionClass;
use SLiMSOAuth\Provider\Contract;

final class OAuthFactory
{
    private static string $error = '';
    private static string $currentDriver = '';
    private static $driverInstance = null;
    
    public static function use(string $driver)
    {
        if (!class_exists($driver)) throw new Exception("Driver {$driver} not found!");
        
        if (!is_null(self::$driverInstance)) return;

        try {
            $driverInstance = new $driver;
        
            if ($driverInstance instanceof Contract)
            {
                self::$currentDriver = (new ReflectionClass($driverInstance))->getShortName();
                self::$driverInstance = $driverInstance;
            }
            else
            {
                throw new Exception("Driver {$driver} is not extends SLiMSOAuth\Driver\Contract");
            }
        } catch (Exception $e) {
            self::$error = $e->getMessage();
        }
    }

    public static function auth(Closure $next)
    {
        $OAuthFactory = new Static;
        
        try {
            // Driver authentication and Create user
            self::$driverInstance->auth()->createIfExists();

            // Next process
            $next($OAuthFactory);
            
        } catch (Exception $e) {
            $OAuthFactory->error = $e->getMessage();
        }
    }

    public static function revoke()
    {
        self::$driverInstance->logout($_SESSION['accessToken']);
    }

    public static function getAuthUrl()
    {
        try {
            return self::$driverInstance->getAuthUrl();
        } catch (Exception $e) {
            self::$error = self::getDriver() . ' OAuth config error : <strong>' . $e->getMessage() . '</strong>';
        }
    }

    public static function getDriver()
    {
        return self::$currentDriver;
    }

    public static function getError()
    {
        $error = '';
        if (!empty(self::$error))
        {
            $error .= self::$error;
        }
        
        if (!is_null(self::$driverInstance) && !empty(self::$driverInstance->getError()))
        {
            $error .= self::$driverInstance->getError();
        }

        return $error;
    }
}