<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-05-19 10:29:29
 * @modify date 2022-05-19 22:45:26
 * @license GPLv3
 * @desc [description]
 */

defined('INDEX_AUTH') OR die('Direct access not allowed!');

// IP based access limitation
require LIB . 'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-system');
// start the session
require SB . 'admin/default/session.inc.php';
// set dependency
require SIMBIO . 'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO . 'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO . 'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO . 'simbio_DB/simbio_dbop.inc.php';
require SIMBIO . 'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require __DIR__ . '/../autoload.php';
// end dependency

// privileges checking
$can_read = utility::havePrivilege('system', 'r');
$can_write = utility::havePrivilege('system', 'w');

if (!$can_read) {
    die('<div class="errorBox">' . __('You are not authorized to view this section') . '</div>');
}

// Is https or not!
isHttps() or die('<div class="errorBox"><strong>HTTPS connection is required. Your SLiMS is not running in https!</strong></div>');

function httpQuery($query = [])
{
    return http_build_query(array_unique(array_merge($_GET, $query)));
}

function currentUrl($query = [])
{
    return $_SERVER['PHP_SELF'] . '?' . httpQuery($query);
}

$page_title = 'SLiMS OAuth';

/* Action Area */

/* End Action Area */
?>
<div class="menuBox">
    <div class="menuBoxInner memberIcon">
        <div class="per_title">
            <h2><?php echo $page_title; ?></h2>
        </div>
    </div>
</div>
<?php
$providers = [
    ['label' => 'Google Oauth2', 'id' => 'google', 'icon' => assetsUrl('images/google-logo.e086107b.svg'), 'active' => true, 'url' => currentUrl(['config' => 'google']), 'disable' => 'checked disabled'],
    ['label' => 'Facebook Oauth2', 'id' => 'facebook', 'icon' => assetsUrl('images/facebook.png'), 'active' => false, 'url' => '#', 'disable' => 'disabled'],
    ['label' => 'Github Oauth2', 'id' => 'github', 'icon' => assetsUrl('images/github.png'), 'active' => false, 'url' => '#', 'disable' => 'disabled'],
    ['label' => 'Instagram Oauth2', 'id' => 'instagram', 'icon' => assetsUrl('images/instagram.png'), 'active' => false, 'url' => '#', 'disable' => 'disabled']
];

if (isset($_GET['config']) && !empty($_GET['config']) && file_exists($path = __DIR__ . '/' . basename($_GET['config']) . '.comp.php'))
{
    include $path;
    exit;
}

?>
<div class="card-group p-3">
    <?php
    $card = '';
    foreach ($providers as $provider) {
        extract($provider);
        $installationStatus = $active ? '<i class="fa fa-gear"></i> Config' : 'Not installed';
        $switchLabel = $active ? 'Active' : 'Disable';
        $configLabelLock = $active ? '' : 'disabled';
        $card .= <<<HTML
            <div class="card mx-2">
                <img src="{$icon}" class="card-img-top w-25 mt-5 p-2 d-block mx-auto"  alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center">{$label}</h5>
                    <div class="card-text d-flex justify-content-between">
                        <button data-url="{$url}" class="btn btn-link btn-config {$configLabelLock}">{$installationStatus}</button>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" id="{$id}" class="custom-control-input" {$disable}>
                            <label class="custom-control-label" for="{$id}">{$switchLabel}</label>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }

    echo $card;
    ?>
</div>
<div class="w-100 mt-5 text-center">
    <strong class="text-secondary d-block mx-auto col-8">Another OAuth provider is available in another "Universe", call <a href="https://t.me/drajathasan">"Doctor D"</a> to cast a spell to make another provider available in your universe.</strong>
</div>
<script>
    $('.btn-config').click(function(){
        $('#mainContent').simbioAJAX($(this).data('url'));
    })
</script>