<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-18 14:42:27
 * @modify date 2022-05-21 11:01:02
 * @license GPLv3
 * @desc [description]
 */

namespace SLiMSOAuth;

use Exception,Closure,ReflectionClass;
use SLiMSOAuth\Provider\Contract;

final class OAuthFactory
{
    /**
     * OAuthFactory error property
     *
     * @var string
     */
    private static string $error = '';

    /**
     * Provider name
     *
     * @var string
     */
    private static string $currentProvider = '';

    /**
     * Provider instance
     *
     * @var null|object
     */
    private static $providerInstance = null;
    
    /**
     * Create provider instance 
     *
     * @param string $provider
     * @return void
     */
    public static function use(string $provider)
    {
        if (!class_exists($provider)) throw new Exception("Provider {$provider} not found!");
        
        if (!is_null(self::$providerInstance)) return;

        try {
            $providerInstance = new $provider;
        
            if ($providerInstance instanceof Contract)
            {
                self::$currentProvider = (new ReflectionClass($providerInstance))->getShortName();
                self::$providerInstance = $providerInstance;
            }
            else
            {
                throw new Exception("Provider {$provider} is not extends SLiMSOAuth\Provider\Contract");
            }
        } catch (Exception $e) {
            self::$error = $e->getMessage();
        }
    }

    /**
     * Authentication process 
     * with callback handle by user;
     *
     * @param Closure $next
     * @return void
     */
    public static function auth(Closure $next)
    {
        $OAuthFactory = new Static;
        
        try {
            // Provider authentication and Create user
            self::$providerInstance->auth()->createIfNotExists();

            // Next process
            $next($OAuthFactory);
            
        } catch (Exception $e) {
            self::$error = $e->getMessage();
        }
    }

    /**
     * Logout and revoke 
     * last user login
     *
     * @return void
     */
    public static function revoke()
    {
        self::$providerInstance->logout($_SESSION['accessToken']);
    }

    /**
     * Getter for OAuth provider URL
     *
     * @return void
     */
    public static function getAuthUrl()
    {
        try {
            $url = self::$providerInstance->getAuthUrl();
            return self::$providerInstance->createButtonAuth($url);
        } catch (Exception $e) {
            self::$error = self::getProvider() . ' OAuth config error : <strong>' . $e->getMessage() . '</strong>';
        }
    }

    /**
     * Get current provider name
     *
     * @return void
     */
    public static function getProvider()
    {
        return self::$currentProvider;
    }

    /**
     * Get some error from Factory
     * or Provider error
     *
     * @return void
     */
    public static function getError()
    {
        $error = '';
        if (!empty(self::$error))
        {
            $error .= self::$error;
        }
        
        if (!is_null(self::$providerInstance) && !empty(self::$providerInstance->getError()))
        {
            $error .= self::$providerInstance->getError();
        }

        return $error;
    }
}