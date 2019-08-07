<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bio panel</title>
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?= base_url() ?>assets/web/dist/img/ico/fav.png">
        <!-- Start Global Mandatory Style
             =====================================================================-->
        <!-- jquery-ui css -->
        <link href="<?= base_url() ?>assets/web/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css" />
        <!-- materialize css -->
        <link href="<?= base_url() ?>assets/web/plugins/materialize/css/materialize.min.css" rel="stylesheet">
        <!-- Bootstrap css-->
        <link href="<?= base_url() ?>assets/web/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Animation Css -->
        <link href="<?= base_url() ?>assets/web/plugins/animate/animate.css" rel="stylesheet" />
        <!-- Material Icons CSS -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Dropzone css -->
        <link href="assets/web/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome -->
        <link href="<?= base_url() ?>assets/web/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Monthly css -->
        <link href="<?= base_url() ?>assets/web/plugins/monthly/monthly.css" rel="stylesheet" type="text/css" />
        <!-- simplebar scroll css -->
        <link href="<?= base_url() ?>assets/web/plugins/simplebar/dist/simplebar.css" rel="stylesheet" type="text/css" />
        <!-- mCustomScrollbar css -->
        <link href="<?= base_url() ?>assets/web/plugins/malihu-custom-scrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
        <!-- custom CSS -->
        <link href="<?= base_url() ?>assets/web/dist/css/stylematerial.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/web/css/calculator.css" rel="stylesheet">
       

        <!--AgularJS-->
       <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/web/js/angularJs.js"></script>
        <script src="<?= base_url() ?>assets/web/js/dirPagination.js"></script>
         <script src="https://cdn.jsdelivr.net/alasql/0.3/alasql.min.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/alasql/0.3.7/alasql.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.9.2/xlsx.core.min.js"></script>
     
    </head>
    <body ng-app="myStock" ng-controller="StockCtrl" >
        <div id="wrapper">