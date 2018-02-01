<?php

use yii\helpers\Url;
use yii\helpers\Html;

// required js files
$this->registerJsFile( '@web/material/js/plugins/tables/datatables/datatables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/tables/datatables/extensions/responsive.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// required js files
$this->registerJsFile( '@web/material/js/plugins/forms/inputs/touchspin.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switch.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/forms/styling/switchery.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// custom js file for this page
$this->registerJsFile( '@web/js/sellers-statistics.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// title
$this->title = "Статистика по Продавцам";
?>

<!-- Form validation -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $this->title ?></h5>
    </div>

    <div class="panel-body">

        <table class="table sellers-list-datatable">
        </table>

    </div>

</div>
<!-- /form validation -->
