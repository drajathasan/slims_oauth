<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-18 08:05:39
 * @modify date 2022-05-21 10:59:46
 * @license GPLv3
 * @desc [description]
 */

namespace SLiMSOAuth\Provider;

use Exception,PDOException;
use Google_Service_Oauth2 as Oauth2;
use Google\Client;
use SLiMS\DB;
use SLiMSOAuth\Secret\Google as GoogleSecret;
use SLiMSOAuth\Models\Member;

class Google extends Contract
{
    use GoogleSecret;

    /**
     * Setup client and set vendor credential
     */
    public function __construct()
    {
        $this->client = new Client;
        $this->setCredential();
    }

    /**
     * Google\Client authentication
     *
     * @return void
     */
    public function auth()
    {
        try {
            
            // Token process
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
            
            // token check
            if (!isset($token['access_token'])) throw new Exception("Token not available");

            // set access token
            $_SESSION['accessToken'] = $token['access_token'];
            $this->client->setAccessToken($token['access_token']);

            // OAuth Process
            $oauth2 = new Oauth2($this->client);
            $this->accountInfo = $oauth2->userinfo->get();

        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }

        return $this;
    }

    /**
     * Check and Create member data
     * if not exists
     *
     * @return void
     */
    public function createIfNotExists()
    {
        // Authentication is failed? give a null!;
        if (!property_exists($this, 'accountInfo')) return;

        // Make sure 
        $Member = Member::select('member.member_id', 'member.member_name', 'member.inst_name','member.member_email', 'member.expire_date', 'member.register_date', 'member.is_pending','member.member_type_id', 'mt.member_type_name', 'mt.enable_reserve', 'mt.reserve_limit', 'member.member_image')
                            ->leftJoin('mst_member_type AS mt', ['mt.member_type_id', '=', 'member.member_type_id'])
                            ->where('member.member_email', $this->accountInfo->email)->get();

        if (is_null($Member))
        {
            // set new image name
            $image = md5(date('Y-m-d H:i:s') . rand(1,100)) . '.jpg';
            
            // Create new instance
            $Member = new Member;
            $Member->member_id = substr($this->accountInfo->id, 0,20);
            $Member->member_name = $this->accountInfo->name;
            $Member->member_email = $this->accountInfo->email;
            $Member->member_image = $image;
            $Member->gender	= 0;
            $Member->expire_date = date('Y-m-d', strtotime('+1 year'));
            $Member->register_date = date('Y-m-d');
            $Member->is_pending = 1;
            
            if (is_null($Member->save())) throw new Exception('Failed to create member data');

            downloadImage($this->accountInfo->picture, SB . 'images/persons/' . $image);
        }

        $this->createSession($Member);
    }

    /**
     * Create member session
     *
     * @param Object $Member
     * @return void
     */
    protected function createSession(Object $Member)
    {
        // fill all sessions var
        $_SESSION['mid'] = $Member->member_id;
        $_SESSION['m_name'] = $Member->member_name;
        $_SESSION['m_email'] = $Member->member_email;
        $_SESSION['m_institution'] = null;
        $_SESSION['m_logintime'] = time();
        $_SESSION['m_expire_date'] = $Member->expire_date;
        $_SESSION['m_member_type_id'] = $Member->member_type_id;
        $_SESSION['m_member_type'] = $Member->member_type_name;
        $_SESSION['m_register_date'] = $Member->register_date;
        $_SESSION['m_membership_pending'] = intval($Member->is_pending)?true:false;
        $_SESSION['m_is_expired'] = false;
        $_SESSION['m_mark_biblio'] = array();
        $_SESSION['m_can_reserve'] = false;
        $_SESSION['m_reserve_limit'] = 1;
        $_SESSION['m_image'] = $Member->member_image;

        // check member expiry date
        require_once SIMBIO.'simbio_UTILS/simbio_date.inc.php';
        $_curr_date = date('Y-m-d');
        if (\simbio_date::compareDates($Member->expire_date, $_curr_date) == $_curr_date) {
            $_SESSION['m_is_expired'] = true;
        }

        // update member
        $UpdateMember = Member::find($Member->member_id);
        $UpdateMember->last_login_ip = $_SERVER['REMOTE_ADDR'];
        $UpdateMember->last_login = date('Y-m-d H:i:s');
        $UpdateMember->save();
    }

    /**
     * Revoke Google\Client token
     *
     * @param string $token
     * @return void
     */
    public function logout(string $token = '')
    {
        $this->client->revokeToken($token);
    }

    /**
     * Get some error
     *
     * @return void
     */
    public function getError()
    {
        return isset($this->error) ? $this->error : null;
    }

    /** 
     * Get vendor authentication URL
     */
    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Generate html button 
     *
     * @param string $url
     * @return void
     */
    public function createButtonAuth(string $url)
    {
        $disabled = empty($url) ? 'disabled' : '';
        $icon = assetsUrl('images/google-logo.e086107b.svg');
        return <<<HTML
            <div class="d-block my-2">
                <a href="{$url}" class="btn btn-outline-primary {$disabled}"><img class="w-5 h-5 mr-2" src="{$icon}"/> Login With Google</a>
            </div>
        HTML;
    }
}