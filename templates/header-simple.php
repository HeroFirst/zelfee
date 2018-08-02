<?php
/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var array $AppMenuCounter
 *
 */

$bodyClass = '';

if ($AppRendererHelper != null && $AppRendererHelper->getCurrentMenuItem(\Zelfi\Menu\MenuConfiguration::MENU_ID)){
    $bodyClass.= ' page-'.$AppRendererHelper->getCurrentMenuItem(\Zelfi\Menu\MenuConfiguration::MENU_ID)['class'].' ';
}

foreach ($AppRendererHelper->getBodyClasses() as $class){
    $bodyClass.=' '.$class.' ';
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Зеленый Фитнес - культурно-спортивное движение</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="google-site-verification" content="NCRF5mNTx477srV9RoPvsobIt3hLoqdaSIrZiZhIhpA" />
    <meta name="apple-mobile-web-app-title" content="Зеленый фитнес">
    <meta name="application-name" content="Зеленый фитнес">
    <meta name="theme-color" content="#ffffff">
    <?php
    if ($AppRendererHelper->getPartMeta() != null)
        foreach ($AppRendererHelper->getPartMeta() as $part):
            require_once __DIR__.'/parts/meta/'.$part.'.php';
        endforeach; ?>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link href="/assets/plugins/bootstrap-select-1.11.2/css/bootstrap-select.css" rel="stylesheet">
    <link href="/assets/plugins/lightslider/css/lightslider.css" rel="stylesheet">
    <link href='/assets/css/styles.css?<?=\Zelfi\Config\Config::CURRENT_VERSION_CODE?>' rel='stylesheet' type='text/css'>
    <link href="/assets/plugins/cropper/cropper.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="<?=$bodyClass?>">
<?php if (\Zelfi\Utils\ProductionHelper::getServerType() !=0): ?>
    <div style="background-color: #ff0000; color: white; padding: 2px 0;" class="text-center">
        DEBUG
    </div>
<?php endif; ?>
<?php
if ($AppRendererHelper->getHeaderData() != null)
    foreach ($AppRendererHelper->getHeaderData() as $data):
        require_once '/data/'.$data.'.php';
    endforeach; ?>

<div class="container-main">

    <div class="header-simple">
        <div class="header-top">
            <div class="container">
                <div class="pull-left" <?=$AppUser->getCity() == 2 ? '' : "style='visibility:hidden;'"?> >
                    <img class="header-top-logo" src="/assets/images/header_logo_tatneft.png" />
                    <div class="header-top-divider"></div>
                    <p class="header-top-title">Генеральный партнер</p>
                </div>
                <div class="pull-right">
                    <ul class="header-items">
                        <li class="item city">
                            <a href="#" class="zf-selector" data-toggle="modal" data-target="#modalCity">
                                <span class="title">Ваш город:</span>
                                <span class="value"><?=$AppUser->getInfoItem('city_name')?>  <span class="caret"></span></span>
                            </a>
                        </li>
                        <?php if ($AppUser->getRole()<6): ?>
                            <li class="item profile">
                                <a href="/users/me">
                                    <img src="<?=$AppUser->getInfoItem('photo_small')?>" />
                                    <span><?=$AppUser->getInfoItem('first_name')?></span>
                                </a>
                            </li>
                            <li class="item default">
                                <a href="/<?=$AppUser->getInfoItem('city_alias')?>/rating">
                                    <span class="card-pink-bg">
                                        <?=\Zelfi\Utils\AppUtils::plural_form(
                                            (
                                            $AppUser->getInfoItem('balls')['balls'] ? $AppUser->getInfoItem('balls')['balls'] : 0
                                            )
                                            , ['балл', 'балла', 'баллов'])?>
                                    </span>
                                </a>
                            </li>
                            <li class="item exit">
                                <a href="/auth/logout?redirect=<?=$_SERVER['REQUEST_URI']?>">
                                    <img src="/assets/images/icon_exit_inverse.png">
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="item auth">
                                <a href="#" data-toggle="modal" data-target="#modalAuth">
                                    <span>Войти</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-body">
            <div class="container">
                <div class="row">
                    <div class="col-xs-4">
                        <a href="/">
                            <img class="header-logo" src="/assets/images/header_logo.png" />
                        </a>

                        <p class="header-title">                            
                                Твои бесплатные тренировки                            
                        </p>
                    </div>
                    <div class="col-xs-8">
                        <div class="header-menu pull-right">
                            <ul style="padding-left: 0px">
                                <?php $k=0; foreach ($AppRendererHelper->getMenu() as $index => $item):
                                    if ($item['isVisible']): ?>
                                    <li <?= ($item['id'] == $AppRendererHelper->getCurrentId()) ? ('class="active"'): ''; ?> id="<?php echo 'menu'; echo $k=$k+1 ?>" >
                                        <a href="/<?=$AppUser->getInfoItem('city_alias')?><?=$item['link']?>">
                                            <?=$item['title']?>

                                            <?php if (!is_null($AppMenuCounter) && $AppMenuCounter[$item['id']]>0): ?>
                                                <span class="counter"><?=$AppMenuCounter[$item['id']]?></span>
                                            <?php endif; ?>
                                        </a>    <?php if ($k==3) {?>
                                            <div class="simp hit" style="border: 1px solid #f655a0;opacity: 0.9">
                                                <div><a class="content" href="/<?=$AppUser->getInfoItem('city_alias')?><?=$item['link']?>?category=1" style="color: #0c0c0c;padding: 5px">Еженедельные мероприятия ЗФ</a></div>
                                                    <div><a class="content" href="/<?=$AppUser->getInfoItem('city_alias')?><?=$item['link']?>?category=2" style="color: #0c0c0c;padding: 5px">Промо-акции ЗФ</a></div>
                                            </div>
                                        <?php } ?>
                                    </li>

                                <?php
                                endif;
                                endforeach; ?>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>