<?php

use yii\helpers\Url;
use yii\helpers\Html;

//$this->registerJsFile( '@web/material/', ['depends' => [\yii\web\JqueryAsset::className()]] );
//$this->registerJsFile( '@web/material/', ['depends' => [\yii\web\JqueryAsset::className()]] );
//$this->registerJsFile( '@web/material/', ['depends' => [\yii\web\JqueryAsset::className()]] );
//$this->registerJsFile( '@web/material/', ['depends' => [\yii\web\JqueryAsset::className()]] );
//$this->registerJsFile( '@web/material/', ['depends' => [\yii\web\JqueryAsset::className()]] );
//$this->registerJsFile( '@web/material/', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/material/js/plugins/notifications/sweet_alert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]] );
$this->registerJsFile( '@web/js/categories-list.js', ['depends' => [\yii\web\JqueryAsset::className()]] );

$this->title = 'Список категорий';
?>

<!-- csrf token -->
<?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []); ?>

<div class="row">

    <div class="col-md-4">

        <div class="form-group">
            <div class="input-group text-right">
                    <span class="input-group-btn">
                        <button id="remove-section-button" class="btn btn-danger remove-ctg-btn" data-name="section" type="button">-</button>
                    </span>
                <span class="input-group-btn text-left">
                        <button id="add-section-button" class="btn btn-primary add-ctg-btn" data-name="section" type="button">+</button>
                    </span>
            </div>
        </div>

        <div class="panel panel-flat">

            <!-- Разделы -->
            <div class="table-responsive">
                <table id="table-section" class="table table-striped">

                    <thead>
                    <tr>
                        <th><span class="text-bold">Разделы</span></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach($sections as $section) : ?>
                        <tr>
                            <td data-section-id="<?= $section->section_id; ?>"><?= $section->section_name; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
            </div>



        </div>

    </div>
    <!-- /striped rows -->

    <div class="col-md-4">

        <div class="form-group">
            <div class="input-group text-right">
                <span class="input-group-btn">
                    <button id="remove-category-button" class="btn btn-danger remove-ctg-btn" data-name="category" type="button">-</button>
                </span>
                <span class="input-group-btn text-left">
                    <button id="add-category-button" class="btn btn-primary add-ctg-btn" data-name="category" type="button">+</button>
                </span>
            </div>
        </div>

        <div class="panel panel-flat">

            <!-- Разделы -->
            <div class="table-responsive">
                <table id="table-category" class="table table-striped">

                    <thead>
                    <tr>
                        <th><span class="text-bold">Категории</span></th>
                    </tr>
                    </thead>

                    <tbody>
                    </tbody>

                </table>
            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="form-group">
            <div class="input-group text-right">
                <span class="input-group-btn">
                    <button id="remove-subcategory-button" class="btn btn-danger remove-ctg-btn" data-name="subcategory" type="button">-</button>
                </span>
                <span class="input-group-btn text-left">
                    <button id="add-subcategory-button" class="btn btn-primary add-ctg-btn" data-name="subcategory" type="button">+</button>
                </span>
            </div>
        </div>

        <div class="panel panel-flat">

            <!-- Разделы -->
            <div class="table-responsive">
                <table id="table-subcategory" class="table table-striped">

                    <thead>
                    <tr>
                        <th><span class="text-bold">Подкатегории</span></th>
                    </tr>
                    </thead>

                    <tbody>
                    </tbody>

                </table>
            </div>

        </div>

    </div>

</div>
