<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-18 09:19:48
 * @modify date 2022-05-20 14:33:32
 * @license GPLv3
 * @desc [description]
 */

include_once __DIR__ . '/../helper.php';

class SetIndex extends \SLiMS\Migration\Migration
{
    function up()
    {
        if (str_replace(['v','.'], '', SENAYAN_VERSION_TAG) <= '942')
        {
            $originFile = SB . 'index.php';
            $sourceFile = pluginDir('pages/index.slims.php');

            // Backup old file
            if (!file_exists($backupFile = SB . 'index.orig.php'))
            {
                copy($originFile, SB . 'index.orig.php');
            }

            // set new file
            copy($sourceFile, $originFile);
        }
    }

    function down()
    {
        $originFile = SB . 'index.php';

        if (str_replace(['v','.'], '', SENAYAN_VERSION_TAG) <= '942')
        {
            // set new file
            copy(SB . 'index.orig.php', $originFile); 
        }
    }
}