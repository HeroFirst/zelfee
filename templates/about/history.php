<?php
/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *
 */

include __DIR__.'/../header-simple.php'; ?>

    <div class="page-content">
        <div class="container">
                   
                         <div class="row margin-top-40">
                <div class="col-xs-12">
                    <div class="flex flex-vertical-center flex-left-right">
                        <div class="box-title-page">
                            <h1>О нас</h1>
                        </div>

                        <div class="zf-tabs-big">
                            <ul>
                                <li class="active"><a href="/<?=$AppUser->getInfoItem('city_alias')?>/about/history"><span class="zf-icon-about-history-white"></span>Подробнее о ЗФ</a></li>
                                <li><a href="/<?=$AppUser->getInfoItem('city_alias')?>/about/blog"><span class="zf-icon-about-blog"></span>Стратегия 2020</a></li>
                                <li class="hide"><a href="/<?=$AppUser->getInfoItem('city_alias')?>/about/smi"><span class="zf-icon-about-smi"></span> СМИ о нас</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <div class="row">
                    <div class="col-xs-9" style="padding-left:75px; padding-top:40px">
                        <p style="outline: none;list-style: none;border: 0px;margin-bottom: 0px;padding-bottom: 20px;line-height: 2;font-size:14.0pt;color:black">Зеленый Фитнес - это социально-спортивное движение</p>
                        
                            <img src="/assets/images/pres1.jpg" width="1000" height="642"><br>
                            <img src="/assets/images/pres2.jpg" width="1000" height="642"><br>
                            <img src="/assets/images/pres3.jpg" width="1000" height="642"><br>
                            <img src="/assets/images/pres4.jpg" width="1000" height="642"><br>
                            <img src="/assets/images/pres5.jpg" width="1000" height="642"><br>
                            <img src="/assets/images/pres6.jpg" width="1000" height="642"><br>
                            <img src="/assets/images/pres7.jpg" width="1000" height="642"><br>
                            <img src="/assets/images/pres8.jpg" width="1000" height="642"><br>
                            <img src="/assets/images/pres9.jpg" width="1000" height="642"><br>
                            <img src="/assets/images/pres10.jpg" width="1000" height="642"><br>
                            <img src="/assets/images/pres11.jpg" width="1000" height="642"><br>
                            <img src="/assets/images/pres12.jpg" width="1000" height="642"><br>
                            <img src="/assets/images/pres13.jpg" width="1000" height="642"><br>
                            
                    </div>
                </div>

<?php include __DIR__.'/../footer.php' ?>