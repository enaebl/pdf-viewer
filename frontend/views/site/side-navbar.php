<?php
/* @var $this View */

use yii\helpers\Html;
use yii\web\View;
?>

<div class="menu-derecho-container">
    <ul style="margin-top: 10px;">
        <li><a href="" ng-click=""><?= Html::img('@web/img/left_menu_item_01.png', ['id' => 'fa-menu-derecho-01', 'class' => 'fa-menu-derecho']) ?></a></li>
        <li><a href="" ng-click=""><?= Html::img('@web/img/left_menu_item_02.png', ['id' => 'fa-menu-derecho-02', 'class' => 'fa-menu-derecho']) ?></a></li>
        <li><a href="" ng-click=""><?= Html::img('@web/img/left_menu_item_03.png', ['id' => 'fa-menu-derecho-03', 'class' => 'fa-menu-derecho']) ?></a></li>
        <li><a href="" ng-click=""><?= Html::img('@web/img/left_menu_item_04.png', ['id' => 'fa-menu-derecho-04', 'class' => 'fa-menu-derecho']) ?></a></li>
        <li><a href="" ng-click=""><?= Html::img('@web/img/left_menu_item_05.png', ['id' => 'fa-menu-derecho-05', 'class' => 'fa-menu-derecho']) ?></a></li>
    </ul>
    <ul style="bottom: 0px; position: absolute;">
        <li><a href="" ng-click=""><?= Html::img('@web/img/left_menu_item_06.png', ['id' => 'fa-menu-derecho-06', 'class' => 'fa-menu-derecho']) ?></a></li>
        <li><a href="" data-toggle="tooltip" data-placement="right" title="Logout" ng-click="signOut()"><?= Html::img('@web/img/left_menu_item_07.png', ['id' => 'fa-menu-derecho-07', 'class' => 'fa-menu-derecho']) ?></a></li>
    </ul>
</div>