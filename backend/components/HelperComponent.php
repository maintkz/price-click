<?php

namespace backend\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class HelperComponent extends Component
{
    /**
     * @inheritdoc
     * gets data from db and converts it to valid datatables json
     */
    public static function getDataForDataTable($table, $assoc = FALSE)
    {
        if(array_key_exists( 'join_tables',$table) && is_array($table['join_tables'])) {
            $join_query = '';
            foreach($table['join_tables'] as $join_table) {
                $join_query .= " INNER JOIN " . $join_table['name'] . " ON (" . $join_table['name'] . "." . $join_table['join_column'] . " = " . $table['name'] . "." . $join_table['join_column'] . ")";
            }
        }

        if(array_key_exists( 'where', $table) && is_array($table['where'])) {
            $where_query = '';
            foreach($table['where'] as $where) {
                $where_query .= " WHERE " . $where['column'] . "=" . $where['value'];
            }
        }

        $query = "SELECT " . $table['columns'] . " FROM " . $table['name'] . $join_query . $where_query;

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($query);

        $result = $command->queryAll();

        if(!$assoc) {
            for($i=0; $i<count($result); $i++) {
                $product_id = array_pop($result[$i]);
                $product_list_id = array_pop($result[$i]);
                array_push($result[$i], "<a href='#' class='show-product-button' data-list-id='$product_list_id' data-product-id='$product_id'><i class='icon-eye'></i></a><a href='/admin/seller/edit-product/$product_list_id' class='edit-product-button'><i class='icon-pencil4'></i></a><a href='#' class='delete-product-button' data-list-id='$product_list_id' data-product-id='$product_id'><i class='icon-cross2'></i></a>");
                next($result[$i]);
            }
            $data["data"] = array_map('array_values', $result);
        } else {
            $data = $result;
        }

        return $data;
    }

    /**
     * @inheritdoc
     * gets data from db and converts it to valid datatables json
     */
    public function getDataForDataTableSellers($table, $assoc = FALSE)
    {
        if(array_key_exists( 'join_tables',$table) && is_array($table['join_tables'])) {
            $join_query = '';
            foreach($table['join_tables'] as $join_table) {
                if(isset($join_table['core_column']) && !empty($join_table['core_column']))
                    $core_column = $join_table['core_column'];
                else
                    $core_column = $join_table['join_column'];
                $join_query .= " INNER JOIN " . $join_table['name'] . " ON (" . $join_table['name'] . "." . $join_table['join_column'] . " = " . $table['name'] . "." . $core_column . ")";
            }
        }

        if(array_key_exists( 'where', $table) && is_array($table['where'])) {
            $where_query = '';
            foreach($table['where'] as $where) {
                $where_query .= " WHERE " . $where['column'] . "=" . $where['value'];
            }
        }

        $query = "SELECT " . $table['columns'] . " FROM " . $table['name'] . $join_query . $where_query;

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($query);

        $result = $command->queryAll();

        if(!$assoc) {
            for($i=0; $i<count($result); $i++) {
                $status = array_pop($result[$i]);
                if($status) {
                    $htmlStatus = "<span class=\"label label-success\">Активный</span>";
                } else {
                    $htmlStatus = "<span class=\"label label-default\">Неактивный</span>";
                }
                array_push($result[$i], $htmlStatus);
                array_push($result[$i], "<a href='/admin/dealer/view-seller/" . $result[$i]['user_id'] . " ' class='show-product-button' ><i class='icon-eye'></i></a><a href='/admin/dealer/edit-seller/" . $result[$i]['user_id'] . " ' ><i class='icon-pencil4'></i></a><a href='#' class='delete-product-button' data-list-id='$product_list_id' data-product-id='$product_id'><i class='icon-cross2'></i></a>");
                next($result[$i]);
            }
            $data["data"] = array_map('array_values', $result);
        } else {
            $data = $result;
        }

        return $data;
    }

    /**
     * @inheritdoc
     * gets data from db and converts it to valid datatables json
     */
    public function getDataForDataTableDealers($table, $assoc = FALSE)
    {
        if(array_key_exists( 'join_tables',$table) && is_array($table['join_tables'])) {
            $join_query = '';
            foreach($table['join_tables'] as $join_table) {
                if(isset($join_table['core_column']) && !empty($join_table['core_column']))
                    $core_column = $join_table['core_column'];
                else
                    $core_column = $join_table['join_column'];
                $join_query .= " INNER JOIN " . $join_table['name'] . " ON (" . $join_table['name'] . "." . $join_table['join_column'] . " = " . $table['name'] . "." . $core_column . ")";
            }
        }

        if(array_key_exists( 'where', $table) && is_array($table['where'])) {
            $where_query = '';
            foreach($table['where'] as $where) {
                $where_query .= " WHERE " . $where['column'] . "=" . $where['value'];
            }
        }

        $query = "SELECT " . $table['columns'] . " FROM " . $table['name'] . $join_query . $where_query;

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($query);

        $result = $command->queryAll();

        if(!$assoc) {
            for($i=0; $i<count($result); $i++) {
                $status = array_pop($result[$i]);
                if($status) {
                    $htmlStatus = "<span class=\"label label-success\">Активный</span>";
                } else {
                    $htmlStatus = "<span class=\"label label-default\">Неактивный</span>";
                }
                array_push($result[$i], $htmlStatus);
                array_push($result[$i], "<a href='/admin/administrator/view-dealer/" . $result[$i]['user_id'] . " ' class='show-product-button'><i class='icon-eye'></i></a><a href='/admin/administrator/edit-dealer/" . $result[$i]['user_id'] . "' class='edit-product-button'><i class='icon-pencil4'></i></a><a href='#' class='delete-product-button' data-list-id='$product_list_id' data-product-id='$product_id'><i class='icon-cross2'></i></a>");
                next($result[$i]);
            }
            $data["data"] = array_map('array_values', $result);
        } else {
            $data = $result;
        }

        return $data;
    }

    /**
     * @inheritdoc
     * transliterate
     */
    public static function toHtmlStatus($status) {
        if($status) {
            echo "<span class=\"label label-success\">Активный</span>";
        } else {
            echo "<span class=\"label label-default\">Неактивный</span>";
        }
    }

    /**
     * @inheritdoc
     * transliterate
     */
    public static function transliterate($s) {
        $s = (string) $s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
        $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }

    /**
     * @inheritdoc
     * get structure of categories (3 level)
     */
    public static function getCategoriesStructure($array) {
        $numItems = count($array);
        $i = 0;
        foreach($array as $index => $element) {
            if ($i == 0 || $section_id == $element['section_id']) {
                if ($i + 1 == $numItems) {
                    $subcategories[ $element['category_id'] ]['category_name'] = $element['category_name'];
                    $subcategories[ $element['category_id'] ]['subcategories'][ $element['subcategory_id']] = $element['subcategory_name'];

                    $sections[ $section_id ]['section_name'] = $section_name;
                    $sections[ $section_id ]['categories'] = $subcategories;
                } else {
                    $subcategories[ $element['category_id'] ]['category_name'] = $element['category_name'];
                    $subcategories[ $element['category_id'] ]['subcategories'][ $element['subcategory_id']] = $element['subcategory_name'];

                    $category_id = $element['category_id'];
                    $category_name = $element['category_name'];
                    $section_id = $element['section_id'];
                    $section_name = $element['section_name'];
                }
            } elseif ($section_id != $element['section_id']) {
                $sections[ $section_id ]['section_name'] = $section_name;
                $sections[ $section_id ]['categories'] = $subcategories;

                $subcategories = [];
                $subcategories[ $element['category_id'] ]['category_name'] = $element['category_name'];
                $subcategories[ $element['category_id'] ]['subcategories'][ $element['subcategory_id']] = $element['subcategory_name'];

                $category_id = $element['category_id'];
                $category_name = $element['category_name'];
                $section_id = $element['section_id'];
                $section_name = $element['section_name'];
            }
            $i++;
        }
        return $sections;
    }


    /**
     * @inheritdoc
     * get structure of categories (3 level)
     */
    public static function executeSql($query)
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($query);

        try {
            $command->execute();
            return TRUE;
        } catch (\yii\db\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getRole()
    {
        return array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id))[0];
    }
}
