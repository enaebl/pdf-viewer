<?php
/* @var $this View */

use yii\helpers\Html;
use yii\web\View;
?>

<div class="container-fluid" style="padding-right: 30px;">
    <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#w0-collapse"><span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div id="w0-collapse" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;" role="navigation">
        <ul id="w1" class="navbar-nav navbar-right nav">
            <li class="upper-menu"><a href="" ng-click=""><?= Html::img('@web/img/upper_menu_item_01.png', ['class' => 'circ']) ?></a></li>
            <li class="upper-menu"><a href="" ng-click=""><?= Html::img('@web/img/upper_menu_item_02.png', ['class' => 'circ']) ?></a></li>
            <li class="upper-menu"><a href="" ng-click="showModal('upload')"><?= Html::img('@web/img/upper_menu_item_03.png', ['class' => 'circ']) ?></a></li>
            <li class="upper-menu"><a href="" ng-click=""><?= Html::img('@web/img/upper_menu_item_04.png', ['class' => 'circ']) ?></a></li>
            <li class="upper-menu"><a href="" ng-click=""><?= Html::img('@web/img/upper_menu_item_05.png', ['class' => 'circ']) ?></a></li>
            <li class="upper-menu-search"><a href="" ng-click=""><?= Html::img('@web/img/upper_menu_item_06.png', ['class' => 'circ']) ?></a></li>
            <li class="upper-menu"><input class="form-control text-input" style="margin-top: 30px;" type="text" /></li>
        </ul>
    </div>
</div>