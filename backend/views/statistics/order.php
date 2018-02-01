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

$this->registerJsFile( '@web/js/order-statistics.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

$this->title = "Заказ " . $orderGroup['id'];
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
                        <td>Дата</td>
                        <td><span class="text-bold"> <?= $orderGroup['created_date']; ?> </span></td>
                    </tr>
                    <tr>
                        <td>Количество товаров</td>
                        <td><span class="text-bold"><?= $orderGroup['count']; ?> </span></td>
                    </tr>
                    <tr>
                        <td>Общая сумма</td>
                        <td><span class="text-bold"><?= $orderGroup['overall_summ']; ?></span></td>
                    </tr>
                    <tr>
                        <td>Адрес</td>
                        <td><span class="text-bold"><?= $orderGroup['address']; ?></span></td>
                    </tr>
                    <tr>
                        <td>Описание</td>
                        <td><span class="text-bold"><?= $orderGroup['description']; ?></span></td>
                    </tr>
                    <tr>
                        <td>Телефон покупателя</td>
                        <td><span class="text-bold"><?= $orderGroup['phone']; ?></span></td>
                    </tr>
                    <tr>
                        <td>Статус</td>
                        <td><span class="text-bold"><?= $orderGroup['status']; ?></span></td>
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

            <table id="sellers-of-dealer" class="table orders-list-datatable">
            </table>

        </div>

    </div>

</div>