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
$this->registerJsFile( '@web/js/dealers-list.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

// title
$this->title = "Список дилеров";
?>

<!-- Form validation -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $this->title ?></h5>
    </div>

    <div class="panel-body">

        <table class="table datatable-responsive products-list-datatable">
        </table>

    </div>

</div>
<!-- /form validation -->
