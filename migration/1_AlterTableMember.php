<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-18 09:19:48
 * @modify date 2022-05-18 09:23:38
 * @license GPLv3
 * @desc [description]
 */

class AlterTableMember extends \SLiMS\Migration\Migration
{
    function up()
    {
        \SLiMS\DB::getInstance()->query("ALTER TABLE `member` CHANGE `member_id` `member_id` varchar(64) COLLATE 'utf8mb3_unicode_ci' NOT NULL FIRST;");
    }

    function down()
    {
        \SLiMS\DB::getInstance()->query("ALTER TABLE `member` CHANGE `member_id` `member_id` varchar(20) COLLATE 'utf8mb3_unicode_ci' NOT NULL FIRST;");
    }
}