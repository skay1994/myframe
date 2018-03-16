<!DOCTYPE html>
<html lang="<?= $lang ?? '' ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <base href="<?= $base ?>">
    <title><?= $title ?></title>

    <!-- Bootstrap -->
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- Font Awesome -->
    <link href="/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- NProgress -->
<!--    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">-->

    <link href="/bower_components/iCheck/skins/flat/green.css" rel="stylesheet" type="text/css">

    <link href="/assets/pnotify/pnotify.custom.min.css" rel="stylesheet" type="text/css">

    <!-- Custom Theme Style -->
    <link href="/assets/css/custom.min.css" rel="stylesheet">

    <?= $style ?? '' ?>

    <script>
        var baseAPI = '<?=base_url('api/')?>'
    </script>
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">