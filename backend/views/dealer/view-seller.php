<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->registerJsFile( '@web/material/js/plugins/forms/inputs/touchspin.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switch.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switchery.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/uniform.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/notifications/sweet_alert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
//$this->registerJsFile( '@web/js/view-dealer.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

$this->title = "Информация о продавце";

?>

<!-- csrf token -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th calspan="2"><h6 class="panel-title"><?= $seller->user->username; ?></h6></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Логин</td>
                        <td><span class="text-bold"><?= $seller->user->username; ?></span></td>
                    </tr>
                    <tr>
                        <td>email</td>
                        <td><span class="text-bold"><?= $seller->user->email; ?></span></td>
                    </tr>
                    <tr>
                        <td>Статус</td>
                        <td><span class="text-bold"><?php Yii::$app->helperComponent->toHtmlStatus($seller->status); ?></td>
                    </tr>
                    <tr>
                        <td>Магазины</td>
                        <td><span class="text-bold"><a href="#">Список товаров</a></span></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>