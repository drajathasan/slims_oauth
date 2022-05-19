<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-19 15:12:49
 * @modify date 2022-05-19 16:37:42
 * @license GPLv3
 * @desc [description]
 */

defined('INDEX_AUTH') OR die('Direct access not allowed!');

function addOrUpdateSetting($name, $value) {
    global $dbs;
    $sql_op = new simbio_dbop($dbs);
    $data['setting_value'] = $dbs->escape_string(serialize($value));

    $query = $dbs->query("SELECT setting_value FROM setting WHERE setting_name = '{$name}'");
    if ($query->num_rows > 0) {
        // update
        $sql_op->update('setting', $data, "setting_name='{$name}'");
    } else {
        // insert
        $data['setting_name'] = $name;
        $sql_op->insert('setting', $data);
    }
}

if (isset($_POST['saveData']))
{
    addOrUpdateSetting('oauth_provider', ['class' => "\SLiMSOAuth\Provider\Google", 'ClientId' => $_POST['ClientId'], 'ClientSecret' => $_POST['ClientSecret'], 'RedirectUrl' => $_POST['RedirectUrl'], 'MessageForNewMember' => $_POST['MessageForNewMember']]);
    unset($_GET['config']);
    $url = $_SERVER['PHP_SELF'] . '?' . httpQuery(['config' => 'dashboard']);
    utility::jsToastr('Success', 'Config saved', 'success');
    echo "<script>parent.$('#mainContent').simbioAjax('{$url}')</script>";
    exit;
}

// create new instance
$form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'] . '?' . httpQuery(), 'post');
$form->submit_button_attr = 'name="saveData" value="' . __('Save') . '" class="s-btn btn btn-default"';

// form table attributes
$form->table_attr = 'id="dataList" cellpadding="0" cellspacing="0"';
$form->table_header_attr = 'class="alterCell"';
$form->table_content_attr = 'class="alterCell2"';

$form->addTextField('text', 'ClientId', 'Client Id', $sysconf['oauth_provider']['ClientId']??'', 'class="form-control"');
$form->addTextField('text', 'ClientSecret', 'Client Secret', $sysconf['oauth_provider']['ClientSecret']??'', 'class="form-control"');
$form->addTextField('text', 'RedirectUrl', 'Redirect Url', $sysconf['oauth_provider']['RedirectUrl']??'', 'class="form-control"');
$form->addTextField('textarea', 'MessageForNewMember', 'Message For New Member', $sysconf['oauth_provider']['MessageForNewMember']??'', 'class="form-control"');

// print out the form object
echo $form->printOut();
?>