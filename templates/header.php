<?php
/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 * @var array $AppMenuCounter
 *
 */

if ($AppRendererHelper->getCurrentMenuItem(\Zelfi\Menu\MenuConfiguration::MENU_ID) != null){
    $bodyClass = ' class="page-'.$AppRendererHelper->getCurrentMenuItem(\Zelfi\Menu\MenuConfiguration::MENU_ID)['class'].'"';
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
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link href='/assets/css/styles.css?<?=\Zelfi\Config\Config::CURRENT_VERSION_CODE?>' rel='stylesheet' type='text/css'>
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/hit_area.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body<?=$bodyClass?>>
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

<div class="header-background">
    <div class="header-background-media" style="background-image: url(/assets/images/header_background_image.png)">
        <div class="overlay"></div>
    </div>
    <div class="header-background-placeholder" style="background-image: url(/assets/images/header_background_placeholder.png);">
        <div class="overlay"></div>
    </div>
</div>

<div class="container-main" style="position: relative">
    <div class="header">
        <div class="container">
            <div class="header-top">
                <div class="row">
                    <div class="col-xs-12" <?=$AppUser->getCity() == 2 ? '' : "style='visibility:hidden;'"?> >
                        <img class="header-top-logo" src="/assets/images/header_logo_tatneft.png" />
                        <div class="header-top-divider"></div>
                        <p class="header-top-title">Генеральный партнер</p>
                    </div>
                </div>
            </div>

            <div class="header-body" style="background: #fff;border-radius: 5px;width: 100%;">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="pull-left" style="padding: 14px 30px 13px 30px">
                            <a href="/">
                                <img class="header-logo" src="/assets/images/header_logo.png" />
                            </a>

                            <p class="header-title">
                                Твои бесплатные тренировки
                            </p>
                        </div>
                        <div class="pull-right" style="margin-right: 15px;">
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
                                            <div class="avatar" style="background-image: url(<?=$AppUser->getInfoItem('photo_small')?>)"></div>
                                            <span><?=$AppUser->getInfoItem('first_name')?></span>
                                        </a>
                                    </li>
                                    <li class="item default">
                                        <a href="/<?=$AppUser->getInfoItem('city_alias')?>/rating">
                                            <span class="pink">
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
                                            <img src="/assets/images/icon_exit.png">
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
            </div>

            <div class="header-bottom">
                <div class="header-bottom-menu">
                
                    <?php $k=0; foreach ($AppRendererHelper->getMenu() as $index => $item):
                        if ($item['isVisible']): ?>
                            <div class="item <?php echo "menu"; echo $k=$k+1 ?><?= ($item['id'] == $AppRendererHelper->getCurrentId()) ? 'active': ''; ?> " style="height: 60px">
                                <a href="/<?=$AppUser->getInfoItem('city_alias')?><?=$item['link']?>">
                                    <div class="content" style="margin-bottom: 10px">
                                        <?=$item['title']?>
                                        <?php if (!is_null($AppMenuCounter) && $AppMenuCounter[$item['id']]>0): ?>
                                            <span class="counter"><?=$AppMenuCounter[$item['id']]?></span>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            <?php if ($k==3) {?>
                                <div class="hit">

                                    <div><a class="content" href="/<?=$AppUser->getInfoItem('city_alias')?><?=$item['link']?>?category=1" style="color: #0c0c0c;">Еженедельные мероприятия ЗФ</a></div>
									
                                    <div><a class="content" href="/<?=$AppUser->getInfoItem('city_alias')?><?=$item['link']?>?category=2" style="color: #0c0c0c">Мероприятия города</a></div>
                                    
                                 
								

                                </div>
                            <?php } ?>
                              </div>

                            <?php
                        endif;
                    endforeach; ?>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>