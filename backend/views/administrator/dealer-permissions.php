<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 24.01.2018
 * Time: 17:15
 */

print_r($dealers);
?>

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
            </tr>
            </thead>
            <tbody>

                <?php
                foreach ($dealers as $dealer) {
                ?>
                <tr>
                    <td><?= $dealer['user_id']; ?></td>
                    <td><?= $dealer['email']; ?></td>
                    <td><?= $dealer['username']; ?></td>
                    <td><?= $dealer['status']; ?></td>
                </tr>
                <?php
                }
                ?>

            </tbody>
        </table>

    </div>

</div>
