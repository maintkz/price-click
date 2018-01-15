<?php

use yii\helpers\Url;
use yii\helpers\Html;

// required js files
$this->registerJsFile( '@web/material/js/plugins/tables/datatables/datatables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/tables/datatables/extensions/responsive.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/tables/datatables/datatables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// required js files
$this->registerJsFile( '@web/material/js/plugins/forms/validation/validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/bootstrap_multiselect.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/inputs/touchspin.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switch.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switchery.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/uniform.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/uploaders/fileinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/selects/bootstrap_select.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/pickers/color/spectrum.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/notifications/sweet_alert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// custom js file for this page
$this->registerJsFile( '@web/js/dealers-list.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// title
$this->title = "Список дилеров";
?>

<!-- Form validation -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $this->title ?></h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
                <li><a data-action="reload"></a></li>
                <li><a data-action="close"></a></li>
            </ul>
        </div>
    </div>

    <div class="panel-body">

        <table class="table products-list-datatable">
            <thead>
            <tr>
                <th>id</th>
                <th>email</th>
                <th>Логин</th>
                <th>Статус</th>
                <th>Действие</th>
            </tr>
            </thead>
        </table>

    </div>

</div>
<!-- /form validation -->
