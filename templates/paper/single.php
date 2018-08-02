<?php
/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *
 */

include __DIR__.'/../header-simple.php'; ?>

        <div class="page-content">
            <div class="container">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="cover" style="background: url(<?=($paper['cover_big']!='' ? $paper['cover_big'] : $paper['cover'])?>)">
                            <div class="overlay"></div>

                            <?php if ($paper['type'] != '' ):?>
                                <span class="category"><?=$paper['type_name']?></span>
                            <?php endif; ?>

                            <div class="zf-social-buttons-container">
                                <div class='zf-social-button zf-social-button-vk share s_vk'>
                                    <div class='counter c_vk'>0</div>
                                    <div class='icon'>
                                        <img />
                                    </div>
                                </div>

                                <div class='zf-social-button zf-social-button-fb share s_facebook'>
                                    <div class='counter c_facebook'>0</div>
                                    <div class='icon'>
                                        <img />
                                    </div>
                                </div>

                                <div class='zf-social-button zf-social-button-ok share s_odnoklassniki'>
                                    <div class='counter c_odnoklassniki'>0</div>
                                    <div class='icon'>
                                        <img />
                                    </div>
                                </div>

                                <div class='zf-social-button zf-social-button-mailru share s_myworld'>
                                    <div class='counter c_myworld'>0</div>
                                    <div class='icon'>
                                        <img />
                                    </div>
                                </div>

                                <div class='zf-social-button zf-social-button-gplus share s_plus'>
                                    <div class='counter c_plus'>0</div>
                                    <div class='icon'>
                                        <img />
                                    </div>
                                </div>

                            </div>

                            <div class="body-bottom">
                                <div class="author">
                                    <div style="background-image: url(<?=$paper['user']['photo_small']?>)" class="author-cover"></div>
                                    <span class="author-name"><?=$paper['user']['first_name'].' '.$paper['user']['last_name']?></span>
                                </div>
                                <h1><?=$paper['title']?></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="article-info margin-top-10">
                            <div class="item">
                                Опубликовано: <span><?=\Zelfi\Utils\DateHelper::getDateFromDateTIme($paper['date_publish'])?></span>
                            </div>

                            <div class="item">
                                Автор: <span><?=$paper['user']['first_name'].' '.$paper['user']['last_name']?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($AppUser->getRole()<5 ):?>
                    <div class="admin-action margin-top-10">
                        <div class="col-zs-12">
                            <div class="item">
                                <a href="/private/paper/edit/<?=$paper['id']?>" class="button-to-private">Редактировать</a>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>

                <div class="row margin-top-40">
                    <div class="col-xs-9">
                        <?=$paper['description']?>
                    </div>
                </div>

                <div class="row margin-top-40 hide">
                    <div class="col-xs-12">
                        <div class="box-title">
                            <h1>Рекомендуемые статьи</h1>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-40 materials-items hide">
                    <div class="material-item col-xs-3 item">
                        <div class="square">
                            <div class="square-content" style="background-image: url(/assets/images/hot_stuff_item.png);background-size: cover;">Главное
                                <div class="overlay"></div>

                                <span class="category">
                                                Стань лучше
                                            </span>

                                <div class="body-bottom">
                                    <p class="title">
                                        Тренировочный полу-марафон по набережным города Казани
                                    </p>
                                    <div class="info">
                                        <span class="zf-icon zf-icon-calendar">17.11.16</span>
                                        <span class="zf-icon zf-icon-comment">10 комментариев</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="material-item col-xs-3 item">
                        <div class="square">
                            <div class="square-content" style="background-image: url(/assets/images/hot_stuff_item.png);background-size: cover;">
                                <div class="overlay"></div>

                                <span class="category">
                                                Команда
                                            </span>

                                <div class="body-bottom">
                                    <p class="title">
                                        Тренировочный полу-марафон по набережным города Казани
                                    </p>
                                    <div class="info">
                                        <span class="zf-icon zf-icon-calendar">17.11.16</span>
                                        <span class="zf-icon zf-icon-comment">10 комментариев</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="material-item col-xs-3 item">
                        <div class="square">
                            <div class="square-content" style="background-image: url(/assets/images/hot_stuff_item.png);background-size: cover;">
                                <div class="body-bottom">
                                    <p class="title">
                                        Тренировочный полу-марафон по набережным города Казани
                                    </p>
                                    <div class="info">
                                        <span class="zf-icon zf-icon-calendar">17.11.16</span>
                                        <span class="zf-icon zf-icon-comment">10 комментариев</span>
                                    </div>
                                </div>

                                <div class="overlay"></div>
                            </div>
                        </div>
                    </div>

                    <div class="material-item col-xs-3 item">
                        <div class="square">
                            <div class="square-content" style="background-image: url(/assets/images/hot_stuff_item.png);background-size: cover;">
                                <div class="overlay"></div>

                                <span class="category">
                                                Команда
                                            </span>

                                <div class="body-bottom">
                                    <p class="title">
                                        Тренировочный полу-марафон по набережным города Казани
                                    </p>
                                    <div class="info">
                                        <span class="zf-icon zf-icon-calendar">17.11.16</span>
                                        <span class="zf-icon zf-icon-comment">10 комментариев</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        
        <div id="disqus_thread" style="width: 900px;padding-left: 150px";></div>
<script>
/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
/*
var disqus_config = function () {
this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = '//www-zelfi-ru.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>

<?php include __DIR__.'/../footer.php' ?>