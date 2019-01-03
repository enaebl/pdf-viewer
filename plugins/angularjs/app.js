'use strict';

var app = angular.module('MyApp', ['ngRoute', 'ngResource', 'ngSanitize', 'ngLocationUpdate'])
        .filter('unsafe', function ($sce) {
            return $sce.trustAsHtml;
        })
        
        ;
