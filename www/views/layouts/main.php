<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php $this->beginBody() ?>
<img id="loading" src="img/loading.gif" tabindex="-2">
<header>
    <div class="header-top"> 
        <div class="container">
            <div class="header-top-left">
                
                <div class="mob-menu">
                    <div id="lines" class="btn"></div>
                </div><!-- end mob-menu -->

                <div class="logo-wrap">
                    <a href="<?=Url::toRoute('/site/index');?>" class="logo"><img src="images/logos/logo.png" alt="логотип"></a>
                </div>
                <div class="free-offer">
                    <p><?=$this->params["countItems"]?></p>
                    <p>свободных предложений</p>
                </div><!-- end offer -->
                <div class="log-bg log-<?=$this->context->getColorLine();?>"></div><!-- end green-light -->
                <div class="header-select">
                    <a class="popup-modal select-town" href="<?=Url::toRoute('c/modal-city');?>"><?=$this->params["city"]?> <span></span></a>
                </div><!-- end select -->
            </div><!-- end left -->

            <div class="header-top-right">
                <?=$this->context->auth();?> 
            </div><!-- end right -->
        </div><!-- end container -->
    </div><!-- end header-top -->

    <div class="header-bottom">
        <div class="container">
            <nav>
                <ul>
                    <li><a href="/">Главная</a></li>
                    <li><a href="<?=Url::toRoute(['site/page', "name" => "pravila"]);?>">Акции</a></li>
                    <li><a href="<?=Url::toRoute(['site/page', "name" => "contact"]);?>">Контакты</a></li>
                    <li><a href="<?=Url::toRoute(['site/tarif']);?>">Тарифы</a></li>
                    <li><?=$this->render('@app/views/site/podelitsya.php');?></li>
                </ul>
            </nav>

            <div class="header-search">
                <?php $form = ActiveForm::begin(['action' => Url::toRoute('/site/search'), 'method' => 'get']);?>
                    <div class="form-row">
                        <div>
                            <input type="text" placeholder="Поиск" name="SearchForm[search]">
                        </div>
                        <div>
                            <input type="submit" value="" name="search">
                        </div>
                    </div><!-- end row -->
                <?php ActiveForm::end(); ?>
            </div><!-- end searclh -->
        </div><!-- end container -->
    </div><!-- end header-bottom -->
</header>
<?= $content ?>
<footer>
    <div class="container">
        <div class="footer-inner">
            <div class="copyright">
                <p>&copy; Я Свободен 2015</p>
            </div>
            <nav>
                <ul class="footer-nav">
                    <li><a href="/">Главная</a></li>
                    <li><a href="<?=Url::toRoute(['site/page', "name" => "soglashenie"]);?>">Пользовательское соглашение</a></li>
                    <li><a href="<?=Url::toRoute(['site/page', "name" => "dogovor"]);?>">Договор оферты</a></li>
                    <li><a href="<?=Url::toRoute(['site/page', "name" => "contact"]);?>">Контакты</a></li>
                </ul>
            </nav>
        </div><!-- end footer-inner -->
    </div><!-- end container -->
</footer>
<div id="towns-modal" class="white-popup-block mfp-hide" >
</div>
<?php
    $this->registerJsFile(
        'js/modal_city.js',
        ['depends'=>'app\assets\AppAsset'] 
    );
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
