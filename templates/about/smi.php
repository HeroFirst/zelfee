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
                                <li><a href="/<?=$AppUser->getInfoItem('city_alias')?>/about/history"><span class="zf-icon-about-history"></span> История проекта</a></li>
                                <li><a href="/<?=$AppUser->getInfoItem('city_alias')?>/about/blog"><span class="zf-icon-about-blog"></span> Блог ЗФ</a></li>
                                <li class="active"><a href="/<?=$AppUser->getInfoItem('city_alias')?>/about/smi"><span class="zf-icon-about-smi-white"></span> СМИ о нас</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php include __DIR__.'/../footer.php' ?>