<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
   <meta charset="utf-8" />
   <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <?php
        $baseUrl = Yii::app()->theme->baseUrl;
        $cs = Yii::app()->getClientScript();
    ?>
    <?php Yii::app()->bootstrap->register(); ?>
     <script>
        var BASE_URL="<?php print Yii::app()->request->baseUrl;?>";
    </script>
    
    <link rel="icon" type="image/ico" href="<?php echo $baseUrl ?>/css/img/bakouicon.ico" />
    
    <!-- bootstrap & fontawesome -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl ?>/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/font-awesome.min.css" />
    
    <!-- page specific plugin styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/colorbox.css" />
    
    <!-- text fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-fonts.css" />
    
    <!-- ace styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace.min.css" />
    
    <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-part2.min.css" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-skins.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-rtl.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/jquery.gritter.css" />

    <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-ie.min.css" />
    <![endif]-->
    
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/jquery-ui-1.10.4.custom.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/loading_animation.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/select2.css" />
    
    <?php
        $cs->registerScriptFile($baseUrl.'/js/app.min.js',CClientScript::POS_END);

        /* All below *.js merge into app.mini.js */
        /*
        $cs->registerScriptFile($baseUrl.'/js/ace-extra.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/ace-elements.min.js',CClientScript::POS_END);  
        $cs->registerScriptFile($baseUrl.'/js/ace.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/jquery.gritter.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/select2.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/jquery.form.min.js',CClientScript::POS_END);
        */

    ?>

    <?php 
        if (Yii::app()->components['user']->loginRequiredAjaxResponse){
            Yii::app()->clientScript->registerScript('ajaxLoginRequired', '
                jQuery("body").ajaxComplete(
                    function(event, request, options) {
                        if (request.responseText == "'.Yii::app()->components['user']->loginRequiredAjaxResponse.'") {
                            window.location.href = options.url;
                        }
                    }
                );
            ');
        }
    ?>
</head>

<body class="no-skin">
    <div id="menu">
        <!-- #section:basics/navbar.layout -->
        <section id="navigation-main">  
        <!-- Require the navigation -->
        <?php require_once('tpl_navigation_sale.php')?>
        </section> <!-- /#navigation-main --> 
    </div> <!--/ menu -->

    <!-- /section:basics/navbar.layout -->
    <div class="main-container" id="main-container"> 
        <div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse">
            <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
            </script>

            <!-- #section:basics/sidebar.layout.minimize -->
            <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
            </div>

            <!-- /section:basics/sidebar.layout.minimize -->
            <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
            </script>
        </div>
                    
        <?php if(isset($this->breadcrumbs)):?>
              <?php $this->widget('bootstrap.widgets.TbBreadcrumb', array(
                    'links' => $this->breadcrumbs,
              )); ?>
        <?php endif?>
        
        <!-- /section:basics/sidebar.horizontal -->
        <div class="main-content">
            <div class="page-content">
                <div class="row">
                  <div class="col-xs-12">
                    <!-- Include content pages -->
                    <?php echo $content; ?>
                  </div>
                </div>
            </div>
        </div> <!-- /.main-content -->

        <!-- Require the footer -->
        <?php require_once('tpl_footer.php')?>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
            
    </div><!--/.main-container-->
 
   
  </body>
</html>