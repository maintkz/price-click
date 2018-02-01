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

$this->registerJsFile( '@web/js/customer-statistics.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

$this->title = "Статистика покупателя";
print("<pre>".print_r($customer,true)."</pre>");
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
                        <td><span class="text-bold"> <?= $customer['username']; ?> </span></td>
                    </tr>
                    <tr>
                        <td>email</td>
                        <td><span class="text-bold"><?= $customer['email']; ?> </span></td>
                    </tr>
                    <tr>
                        <td>Телефон</td>
                        <td><span class="text-bold"><?= $customer['phone']; ?></span></td>
                    </tr>
                    <tr>
                        <td>Адрес</td>
                        <td><span class="text-bold"><?= $customer['address']; ?></span></td>
                    </tr>
                    <tr>
                        <td>Город</td>
                        <td><span class="text-bold"><?= $customer['city_name']; ?></span></td>
                    </tr>
                    <tr>
                        <td>Количество товаров</td>
                        <td><span class="text-bold"><?= $customer['orders_count']; ?></span></td>
                    </tr>
<!--                    <tr>-->
<!--                        <td>Количество купленных товаров</td>-->
<!--                        <td><span class="text-bold">--><?//= $customer['products_count']; ?><!--</span></td>-->
<!--                    </tr>-->
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