<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->registerJsFile( '@web/material/js/plugins/forms/inputs/touchspin.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switch.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switchery.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/uniform.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

$this->registerJsFile( '@web/material/js/plugins/tables/datatables/datatables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/tables/datatables/extensions/responsive.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

$this->registerJsFile( '@web/js/dealer-statistics.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

$this->title = "Статистика дилера";
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">

            <div class="table-responsive">
                <table id="dealer-info" class="table">
                    <thead>
                    <tr>
                        <th><h6 class="panel-title"></h6></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Логин</td>
                        <td><span class="text-bold"> <?= $dealer['username']; ?> </span></td>
                    </tr>
                    <tr>
                        <td>Информация</td>
                        <td><a href="/admin/administrator/view-dealer/<?= $dealer['id']; ?>"><span class="text-bold">Информация о дилере -  <?= $dealer['username']; ?> </span></a></td>
                    </tr>
                    <tr>
                        <td>Общий доход за все время</td>
                        <td><span class="text-bold"><?php print_r($dealer['overall_summ']); ?></span></td>
                    </tr>
                    <tr>
                        <td>Количество зарегистрированных продавцов</td>
                        <td><span class="text-bold"><?= $dealer['sellers_count']; ?></span></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<div class="panel panel-flat">

    <div class="panel-body">

        <div class="table-responsive">

            <table id="sellers-of-dealer" class="table dealers-list-datatable">
            </table>

        </div>

    </div>

</div>