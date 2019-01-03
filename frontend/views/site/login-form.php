<?php
/* @var $this View */

use yii\web\View;
?>

<div id="login-form" class="col-lg-3 file-content">
    <form name="form" novalidate>
        <div class="col-lg-12 margin-bottom">
            <div class="text-center">
                <p>Please fill out the following form:</p>
            </div>
            <input required ng-keydown="triggerSignIn($event)" ng-model="username" oninput="setCustomValidity('')" oninvalid="setCustomValidity('This field is required')" type="text" name="username" placeholder="Username" autofocus class="form-control text-input margin-bottom" />
            <div ng-show="form.$submitted || form.username.$touched" style="margin-bottom: 13px;">
                <div class="label label-danger" ng-show="form.username.$error.required"><i class="fa fa-user"></i> Your username is required</div>
            </div>
            <input required ng-keydown="triggerSignIn($event)" ng-model="password" oninput="setCustomValidity('')" oninvalid="setCustomValidity('This field cannot is required')" type="password" name="password" placeholder="Password" class="form-control text-input" />
            <div ng-show="form.$submitted || form.password.$touched" style="margin-top: 10px; margin-bottom: 3px;">
                <div class="label label-danger" ng-show="form.password.$error.required"><i class="fa fa-lock"></i> Your password is required</div>
            </div>
            <div ng-show="message !== ''" class="label label-danger"><i class="fa fa-warning"></i> {{message}}</div>
        </div>
        <div class="col-lg-6 margin-bottom">
            <button id="login-button" type="submit" ng-click="signIn()" class="btn btn-default"><i class="fa fa-sign-in"></i> Sign in</button>
        </div>
        <div class="col-lg-6 margin-bottom">
            <a class="pull-right" href="">Forgot password?</a>
        </div>
        <div class="col-lg-12 margin-bottom">
            <a class="form-control btn btn-primary" ng-click="test()"><i class="fa fa-google"></i> Sign in with Google</a>
        </div>
    </form>
</div>
