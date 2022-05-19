<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-18 09:38:15
 * @modify date 2022-05-18 09:41:04
 * @license GPLv3
 * @desc [description]
 */

namespace SLiMSOAuth\Models;

use Zein\Database\Dages\SLiMSModelContract;

class Member extends SLiMSModelContract
{
    protected $Table = 'member';
    protected $PrimaryKey = 'member_id';
    protected $Created_at = 'input_date';
    protected $Updated_at = 'last_update';
}