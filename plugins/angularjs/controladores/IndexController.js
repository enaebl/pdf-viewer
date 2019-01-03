app.controller('IndexController', ['$scope', '$http', '$compile', '$timeout', '$location', function ($scope, $http, $compile, $timeout, $location) {

        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $http.defaults.headers.post['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");

        /*$timeout(function () {
         }, 3000);*/

        $scope.init = function (home_url, auth_info, exception) {
            $scope.auth_info = JSON.parse(auth_info);
            $scope.home_url = home_url;
            $scope.current_page = 1;
            $scope.pages_count = 1;
            $scope.message = '';
            $scope.auto_hide_message = '';
            $scope.searching = false;
            $scope.search_criteria = '';
            $scope.exception = exception;
            $scope.files_list = {};
            $scope.updateInterface();
        };

        $scope.getFilesList = function () {
            $http.get($scope.home_url + "/api/files-list?id=" + $scope.auth_info.data.id).then(function successCallback(response) {
                $scope.files_list = response.data;
            });
        };

        $scope.updateInterface = function () {
            if ($scope.auth_info.guest) {
                $scope.getLoginForm();
            } else {
                $scope.resetFileUploadPlugin(true, 800, 600);
                $scope.getInterfaceElements();
            }
        };

        $scope.triggerSignIn = function (event) {
            if (event.which === 13)
                $scope.signIn();
        };

        $scope.signOut = function () {
            $http.post($scope.home_url + "/api/sign-out").then(function successCallback(response) {
                $scope.auth_info = response.data;
                $scope.exception = '';
                $scope.updateInterface();
            });
        };

        $scope.resetFileUploadPlugin = function (redimensionar, anchura, altura, full) {
            $http.get($scope.home_url + "/site/upload-files-form").then(function successCallback(response) {
                var element = $('#upload-files');
                element.html(response.data);
                $compile(element.contents())($scope);
                'use strict';
                $('#fileupload').fileupload({
                    // Uncomment the following to send cross-domain cookies:
                    //xhrFields: {withCredentials: true},
                    url: $scope.home_url + '/upload-handler/?id=' + $scope.auth_info.data.id,
                    disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator && navigator.userAgent),
                    imageMaxWidth: anchura,
                    imageMaxHeight: altura,
                    imageCrop: redimensionar,
                    dropZone: $('#dropzone')
                });

                $('#fileupload').addClass('fileupload-processing');
                $.ajax({
                    // Uncomment the following to send cross-domain cookies:
                    //xhrFields: {withCredentials: true},
                    url: $('#fileupload').fileupload('option', 'url'),
                    dataType: 'json',
                    context: $('#fileupload')[0]
                }).always(function () {
                    $(this).removeClass('fileupload-processing');
                }).done(function (result) {
                    $(this).fileupload('option', 'done')
                            .call(this, $.Event('done'), {result: result});
                });
            });
        };

        $scope.signIn = function () {
            if ($scope.username && $scope.password) {
                $scope.message = '';
                $scope.auto_hide_message = 'Verifying your credentials. Please wait.';
                $('#login-button').addClass('disabled');
                $http.post($scope.home_url + "/api/sign-in?username=" + $scope.username + "&password=" + $scope.password).then(function successCallback(response) {
                    $scope.auth_info = response.data;
                    if (!$scope.auth_info.guest) {
                        $scope.auto_hide_message = 'Loading your user interface. This may take a few seconds...';
                        $('#div-contenedor-gral').addClass('slideOutLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                            $(this).html('');
                            $(this).removeClass();
                            $(this).addClass('row');
                            $scope.resetFileUploadPlugin(true, 800, 600);
                            $scope.getInterfaceElements();
                        });
                    } else {
                        $scope.auto_hide_message = '';
                        $scope.message = 'Invalid username or password';
                    }
                    $('#login-button').removeClass('disabled');
                });
            }
        };

        $scope.getLoginForm = function () {
            $scope.username = '';
            $scope.password = '';
            $('#w0').addClass('slideOutUp animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass();
                $(this).html('');
                $(this).addClass('navbar navbar-fixed-top');
            });
            $('.menu-derecho-container').addClass('fadeOut animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass();
                $(this).addClass('menu-derecho-container');
                $('.menu-derecho').html('');
            });
            $http.get($scope.home_url + "/site/login-form").then(function successCallback(response) {
                var element = $('.site-error');
                if (element) {
                    element.addClass('fadeOut animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                        $(this).remove();
                    });
                }
                element = $('#div-contenedor-gral');
                element.html(response.data);
                $compile(element.contents())($scope);
                element.addClass('slideInLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    $(this).removeClass();
                    $(this).addClass('row');
                });
            });
        };

        $scope.getInterfaceElements = function () {
            $scope.auto_hide_message = 'Loading your user interface. This may take a few seconds...';
            if ($scope.exception) {
                $scope.loadUpperNavbar();
                $scope.loadSideNavbar();
            } else {
                $scope.loadUploadedFiles();
            }
        };

        $scope.loadUploadedFiles = function () {
            $http.get($scope.home_url + "/api/files-list?id=" + $scope.auth_info.data.id).then(function successCallback(response) {
                $scope.files_list = response.data;
                var div_contenedor_gral = $('#div-contenedor-gral');
                div_contenedor_gral.addClass('slideInLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    $(this).removeClass();
                    $(this).addClass('row');
                });
                $scope.loadUpperNavbar();
                $scope.loadSideNavbar();
            });
        };

        $scope.loadUpperNavbar = function () {
            $http.get($scope.home_url + "/site/upper-navbar").then(function successCallback(response) {
                $scope.auto_hide_message = '';
                var element = $('#w0');
                element.html('');
                element.append(response.data);
                $compile(element.contents())($scope);
                element.addClass('slideInDown animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    $(this).removeClass();
                    $(this).addClass('navbar navbar-fixed-top');

                });
            });
        };

        $scope.loadSideNavbar = function () {
            $http.get($scope.home_url + "/site/side-navbar").then(function successCallback(response) {
                var element = $('.menu-derecho');
                element.html(response.data);
                $compile(element.contents())($scope);
                $('.menu-derecho-container').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    $(this).removeClass();
                    $(this).addClass('menu-derecho-container');
                });
                if (!$scope.exception) {
                    //Loading files container div
                    $http.get($scope.home_url + "/site/pdf-list").then(function successCallback(response) {
                        var div_contenedor_gral = $('#div-contenedor-gral');
                        div_contenedor_gral.html(response.data);
                        $compile(div_contenedor_gral.contents())($scope);
                        div_contenedor_gral.addClass('slideInLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                            $(this).removeClass();
                            $(this).addClass('row');
                        });
                    });
                }
            });
        };

        $scope.showModal = function (tipo_accion, indice) {
            $scope.accion_sobre_producto = tipo_accion;
            switch (tipo_accion) {
                case 'upload':
                    $('#upload-files').modal('show');
                    break;
                default:
                    break;
            }
        };

        $scope.browserDimensions = function () {
            var dimensions = [];
            if (typeof (window.innerWidth) === 'number') {
                dimensions = [window.innerWidth, window.innerHeight];
            } else if (document.documentElement && (document.documentElement.clientWidth
                    || document.documentElement.clientHeight)) {
                dimensions = [document.documentElement.clientWidth,
                    document.documentElement.clientHeight];
            } else if (document.body && (document.body.clientWidth ||
                    document.body.clientHeight)) {
                dimensions = [document.body.clientWidth, document.body.clientHeight];
            }
            return dimensions;
        };

        $scope.getProductsPerPage = function () {
            $scope.message = "Cargando...";
            $('.carousel-inner').fadeOut(100);
            //$('.mobileProductCtn').fadeOut(500);
            $scope.loading_page = true;
            var elemsPerPage = ($scope.browserDimensions()[0] >= 1200) ? 6 : ($scope.browserDimensions()[0] > 768) ? 4 : 2;
            var url = ($scope.prod_or_serv === 'p')
                    ? $scope.home_url + "/api/products-per-type?product_type_id=" + $scope.current_product_type + "&current_page=" + $scope.current_page + "&fixture_type_id=" + $scope.fixture_type_id + "&elems_per_page=" + elemsPerPage
                    : $scope.home_url + "/api/services?current_page=" + $scope.current_page + "&elems_per_page=12";
            $http({
                method: 'GET',
                url: url,
                headers: {'Content-Type': 'application/json'},
            }).then(function successCallback(response) {
                $scope.current_products = response.data.products;
                $scope.message = $scope.current_products.length === 0 ? 'No hay resultados' : '';
                $scope.current_page = response.data.page;
                $scope.pages_count = response.data.pages_count;
                $('.carousel-inner').fadeIn(100, function () {
                    $scope.loading_page = false;
                });
                //$('.mobileProductCtn').fadeIn(500);
            }, function errorCallback(response) {
                $('.carousel-inner').fadeIn(100, function () {
                    $scope.loading_page = false;
                });
                //$('.mobileProductCtn').fadeIn(500);
                $scope.showError(response);
            });
        };

        $scope.changePage = function (page) {
            if (!$scope.loading_page) {
                if (page < 1) {
                    $scope.current_page = $scope.pages_count;
                } else if (page > $scope.pages_count) {
                    $scope.current_page = 1;
                } else {
                    $scope.current_page = page;
                }
                $scope.current_products = [];
                if ($scope.searching) {
                    $scope.changeSearchPage();
                } else {
                    $scope.getProductsPerPage();
                }
            }
        };

        $scope.showError = function (response) {
            $scope.message = response.data;
            $('#modal-error').modal({backdrop: 'static'});
        };

        $scope.test = function () {
            alert($scope.browserDimensions()[0]);
        };

        $scope.showMessage = function (message) {
            $scope.message = message;
            $('#modal-message').modal({backdrop: 'static'});
        };

        $scope.showElement = function (element) {
            $(element).hide();
            $(element).fadeIn(500);
        };

        $scope.hideElement = function (element) {
            $(element).fadeOut(500);
        };

        $scope.search = function (event) {
            $scope.searching = true;
            $scope.search_criteria = String.trim($scope.search_criteria);
            if ($scope.search_criteria.length < 3) {
                $('#input-search').addClass('search-error');
                $scope.message = "Debe escribir al menos 3 caracteres.";
            } else {
                $('#input-search').removeClass('search-error');
                $scope.message = "";
                if (event.which === 13) {
                    $scope.message = "Buscando...";
                    $('.carousel-inner').fadeOut(100);
                    $scope.loading_page = true;
                    var elemsPerPage = ($scope.browserDimensions()[0] >= 1200) ? 6 : ($scope.browserDimensions()[0] > 768) ? 4 : 2;
                    var url = $scope.home_url + "/api/search?criteria=" + $scope.search_criteria + "&current_page=" + $scope.current_page + "&elems_per_page=" + elemsPerPage;

                    $http({
                        method: 'GET',
                        url: url,
                        headers: {'Content-Type': 'application/json'},
                    }).then(function successCallback(response) {
                        $scope.current_products = response.data.products;
                        $scope.message = $scope.current_products.length === 0 ? 'No hay resultados' : '';
                        $scope.current_page = response.data.page;
                        $scope.pages_count = response.data.pages_count;
                        $('.carousel-inner').fadeIn(100, function () {
                            $scope.loading_page = false;
                        });
                    }, function errorCallback(response) {
                        $('.carousel-inner').fadeIn(100, function () {
                            $scope.loading_page = false;
                        });
                        $scope.showError(response);
                    });
                }
            }
        };

        $scope.changeSearchPage = function () {
            $scope.message = "Buscando...";
            $('.carousel-inner').fadeOut(100);
            $scope.loading_page = true;
            var elemsPerPage = ($scope.browserDimensions()[0] >= 1200) ? 6 : ($scope.browserDimensions()[0] > 768) ? 4 : 2;
            var url = $scope.home_url + "/api/search?criteria=" + $scope.search_criteria + "&current_page=" + $scope.current_page + "&elems_per_page=" + elemsPerPage;

            $http({
                method: 'GET',
                url: url,
                headers: {'Content-Type': 'application/json'},
            }).then(function successCallback(response) {
                $scope.current_products = response.data.products;
                $scope.message = $scope.current_products.length === 0 ? 'No hay resultados' : '';
                $scope.current_page = response.data.page;
                $scope.pages_count = response.data.pages_count;
                $('.carousel-inner').fadeIn(100, function () {
                    $scope.loading_page = false;
                });
            }, function errorCallback(response) {
                $('.carousel-inner').fadeIn(100, function () {
                    $scope.loading_page = false;
                });
                $scope.showError(response);
            });
        };

    }]);
