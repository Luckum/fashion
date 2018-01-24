<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=isset($this->meta_description) ? $this->meta_description : Yii::app()->params['seo']['meta_description']?>" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->
    <link rel="icon" type="image/png" href="<?php echo Yii::app()->request->baseUrl; ?>/images/23-15_avatar_black.png">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui-min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/datepicker/datepicker.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/images/flags/flags.css" />
    
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery.js"></script>
    <script type="text/javascript">
        var globals = {
            url      : '<?php echo Yii::app()->request->baseUrl; ?>',
            lang     : '<?php echo Yii::app()->getLanguage(); ?>',
            blog     : 'http://23-15-blog.tumblr.com/',
        };
    </script>
    <script>
        function getAjaxDataStatus(obj, cntrl) {
            if (obj.value != 0) {
                window.location = globals.url + "/control/" + cntrl + "/index/status/" + obj.value;
            } else {
                window.location = globals.url + "/control/" + cntrl;
            }
        }
    </script>

    <title><?php echo CHtml::encode(Yii::t('base', isset($this->title) ? $this->title : $this->pageTitle)); ?></title>
</head>

<body>
<?php echo $content; ?>

<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery-ui.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/eternalSession.js"></script>
</body>
</html>