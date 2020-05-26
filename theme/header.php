<!DOCTYPE html>
<html>
<head>
  <title><?= meta_title(); ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="msapplication-TileColor" content="#000000">
  <meta name="msapplication-TileImage" content="<?= images_url('favicon/ms-icon-144x144.png');?>">
  <meta name="theme-color" content="#000000">
  
  <?php
  wp_enqueue_style('font-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap', false, '1.0.0');
  wp_enqueue_style('font-awesome', theme_url('fonts/font-awesome/css/font-awesome.min.css'), false, '4.7.0');
  wp_enqueue_style('main-style', theme_url('css/main.min.css'), false, '1.0.0');
  wp_enqueue_style('bootstrap-css', libs_url('bootstrap/css/bootstrap.min.css'), false, '1.0.0');
  wp_enqueue_style('fancybox-css', libs_url('fancybox/jquery.fancybox.min.css'), false, '1.0.0');
  wp_enqueue_style('notify-css', libs_url('notify/jquery.notify.min.css'), false, '1.0.0');
  wp_enqueue_style('owl-carousel-css', libs_url('owl-carousel/assets/owl.carousel.min.css'), false, '1.0.0');

  wp_head(); ?>

  <link rel="stylesheet" href="<?= theme_url('css/style.css'); ?>" type="text/css" />
  <link rel="stylesheet" href="<?= theme_url('css/responsive.css'); ?>" type="text/css" />

  <script type="text/javascript">
    var site_url = '<?= home_url(); ?>/';
    var this_url = window.location.href;
    var images_url = '<?= images_url(); ?>';
    var ajax_error_msg = '<?= lexicon('ajax_error_msg'); ?>';

    var sdwidth, sdevice;

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (navigator.userAgent.match(/Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i)) {
      var uagent = 'mobile';
    } else {
      var uagent = 'desktop';
    }
  </script>
  
  <script src="<?= theme_url('js/global.js'); ?>"></script>

  <!--[if lt IE 9]>
    <script src="<?= theme_url('js/libs/html5shiv.min.js'); ?>"></script>
    <script src="<?= theme_url('js/libs/respond.min.js'); ?>"></script>
  <![endif]-->
</head>

<body <?php body_class(); ?>>