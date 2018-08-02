<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *  @var \Zelfi\Model\ZFCities $AppCities
 *  @var array $AppSocialLinks
 */
use Zelfi\Enum\Strings;

if ($AppRendererHelper != null){
    $FooterScripts = $AppRendererHelper->getFooterScripts();
    $FooterData = $AppRendererHelper->getFooterData();
}

$feedbackRedirect = 'http://'.$_SERVER[HTTP_HOST].'?'.http_build_query(array_merge($_GET, array("modal-message" => Strings::feedback_success)));

?>
<div class="footer margin-top-50">
    <div class="container">
        <div class="row">
            <div class="col-xs-4">
                <img class="footer-logo" src="/assets/images/footer_logo.png" />
            </div>
            <div class="col-xs-2">
                <div class="footer-menu">
                    <p class="title">ЗФ</p>
                    <ul class="menu">
                        <li><a class="zf-link" href="/<?=$AppUser->getInfoItem('city_alias')?>/about">О нас</a></li>
                        <li><a class="zf-link" href="/<?=$AppUser->getInfoItem('city_alias')?>/events">Афиша</a></li>
                        <li><a class="zf-link" href="/<?=$AppUser->getInfoItem('city_alias')?>/partners">Партнеры</a></li>
                        <li class="hide"><a class="zf-link" href="/<?=$AppUser->getInfoItem('city_alias')?>/team">Команда</a></li>
                        <li><a class="zf-link" href="/<?=$AppUser->getInfoItem('city_alias')?>/paper">Стань лучше</a></li>
                        <li><a class="zf-link" href="/<?=$AppUser->getInfoItem('city_alias')?>/news">Новости</a></li>
                        <?php if ($AppUser->getRole()<5): ?>
                            <li><a class="zf-link" href="/private/">Панель администратора</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="footer-menu">
                    <p class="title">Участникам</p>
                    <ul class="menu">
                        <li class="hide"><a class="zf-link" href="/faq">Вопрос-Ответ</a></li>
                        <li class="hide"><a class="zf-link" href="/gallery">Фотографии проекта</a></li>
                        <li class="hide"><a class="zf-link" href="/store">Магазин</a></li>
                        <li class="hide"><a class="zf-link" href="/contests">Конкурсы</a></li>
                        <li><a class="zf-link" href="/<?=$AppUser->getInfoItem('city_alias')?>/rating">Рейтинг</a></li>
                        <li class="hide"><a class="zf-link" href="/reviews">Отзывы</a></li>
                        <li class="hide"><a class="zf-link" href="/loyalty-program">Программа лояльности</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="footer-menu">
                    <p class="title">Следите за нами</p>
                    <ul class="menu">
                        <li>
                            <div class="icon">
                                <img src="/assets/images/icon_social_vk.png" />
                            </div>
                            <a href="<?=$AppSocialLinks['vk']?>">Вконтакте</a>
                        </li>
                        <li>
                            <div class="icon">
                                <img src="/assets/images/icon_social_fb.png" />
                            </div>
                            <a href="<?=$AppSocialLinks['fb']?>">Facebook</a>
                        </li>
                        <li> <div class="icon">
                                <img src="/assets/images/icon_social_instagram.png" />
                            </div>
                            <a href="<?=$AppSocialLinks['instagram']?>">Instagram</a>
                        </li>
                        <li> <div class="icon">
                                <img src="/assets/images/icon_social_ok.png" />
                            </div>
                            <a href="<?=$AppSocialLinks['ok']?>">Одноклассники</a>
                        </li>
                        <li> <div class="icon">
                                <img src="/assets/images/icon_social_twitter.png" />
                            </div>
                            <a href="<?=$AppSocialLinks['twitter']?>">Twitter</a>
                        </li>
                        <li> <div class="icon">
                                <img src="/assets/images/icon_social_youtube.png" />
                            </div>
                            <a href="<?=$AppSocialLinks['youtube']?>">Youtube</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="footer-menu">
                    <p class="title">Обратная связь</p>

                    <button data-toggle="modal" data-target="#modalFeedback" class="button button-pink">Напишите нам</button><br>
                    
                    <p class="contactsnum">Или свяжитесь с нами по тел. 89503288202 </p>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="footer-border"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="footer-copyright">
                    <p>
                        Зеленый Фитнес (с) <br />
                        since 2016
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal zf-modal zf-modal-wide fade" tabindex="-1" role="dialog" id="modalAuth">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Авторизация</h4>
            </div>
            <div class="modal-body">
                <form id="form-auth" name="form-auth" method="post" action="/auth/email">
                    <div class="row">
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">E-mail</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Введите эл. почту" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label margin-top-20">Пароль</label>
                            <div class="col-sm-9 margin-top-20">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль" required>
                            </div>
                        </div>
                        <div class="col-xs-8 col-xs-offset-2 margin-top-40">
                            <button type="submit" class="button button-pink button-full-width">Войти</button>
                        </div>
                    </div>
                </form>

                <div class="row margin-top-30">
                    <div class="col-xs-12 text-center">
                        <a href="/recover" class="zf-link">Забыли пароль?</a>
                    </div>
                </div>

                <div class="row margin-top-40">
                    <div class="col-xs-12">
                        <div class="horizontal-divider-container">
                            <div class="line"></div>
                            <div class="text">Или</div>
                            <div class="line"></div>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-40">
                    <div class="col-xs-8 col-xs-offset-2 register-social-items">
                        <div class="register-social-item">
                            <a href="/auth/vk?redirect=<?=$_SERVER['REQUEST_URI']?>" class="social-icon social-icon-vk"></a>
                        </div>
                        <div class="register-social-item">
                            <a href="/auth/fb?redirect=<?=$_SERVER['REQUEST_URI']?>" class="social-icon social-icon-fb"></a>
                        </div>
                        <div class="register-social-item">
                            <a href="/auth/gplus?redirect=<?=$_SERVER['REQUEST_URI']?>" class="social-icon social-icon-gplus"></a>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-40">
                    <div class="col-xs-12">
                        <div class="horizontal-divider-container">
                            <div class="line"></div>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-30">
                    <div class="col-xs-12 text-center">
                        Еще не зарегистрированы? <a href="/register" class="zf-link">Регистрация</a>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal zf-modal fade" tabindex="-1" role="dialog" id="modalCity">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Ваш город</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="zf-list-scroll">
                            <ul>
                                <?php if ($AppCities) foreach ($AppCities->getCities() as $index => $item): ?>
                                    <li class="col-xs-12">
                                        <a href="/<?=$item['alias']?>"><?=$item['name']?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal zf-modal zf-modal-wide fade" id="modalFeedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                <h4 class="modal-title" id="myModalLabel">Написать нам</h4>
            </div>
            <div class="modal-body">

                <form id="form-registration-step-1" action="/app/feedback" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">ФИО</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ваше ФИО" required>
                        </div>
                    </div>

                    <div class="form-group margin-top-30">
                        <label for="email" class="col-sm-3 control-label">E-mail</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Введите ваш e-mail" required>
                        </div>
                    </div>

                    <div class="form-group margin-top-30">
                        <label for="topic" class="col-sm-3 control-label">Тема</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="topic" name="topic" placeholder="Тема сообщения" required>
                        </div>
                    </div>

                    <div class="form-group margin-top-30">
                        <label for="text" class="col-sm-3 control-label">Текст</label>
                        <div class="col-sm-9">
                            <textarea rows="8" class="form-control" id="text" name="text" required></textarea>
                        </div>
                    </div>

                    <div class="form-group margin-top-40">
                        <div class="col-xs-6 col-xs-offset-3">
                            <input type="hidden" name="redirect" value="<?=$feedbackRedirect?>">
                            <button type="submit" class="button button-pink button-full-width">Отправить</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal zf-modal fade" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                <h4 class="modal-title" id="myModalLabel">Сообщение</h4>
            </div>
            <div class="modal-body">
                <h4>
                    <?=$AppRendererHelper->getModalMessage()?>
                </h4>
            </div>
        </div>
    </div>
</div>

<script src="/assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="/assets/js/scripts.js"></script>
<script src="/assets/plugins/jsrender/jsrender.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/js/ie10-viewport-bug-workaround.js"></script>
<script src="/assets/plugins/bootstrap-select-1.11.2/js/bootstrap-select.min.js"></script>
<script src="/assets/plugins/lightslider/js/lightslider.min.js"></script>
<script src="/assets/plugins/social-share/SocialShare.min.js"></script>
<script id="digits-sdk" src="https://cdn.digits.com/1/sdk.js"></script>
<script src="/assets/plugins/cropper/cropper.min.js"></script>
<!— Yandex.Metrika counter —> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter40924414 = new Ya.Metrika({ id:40924414, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/40924414" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!— /Yandex.Metrika counter —>
    <script>
        $(document).ready(function() {
            $('#modalMessage').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);

                if (button != undefined){
                    var message = button.data('message');

                    if (message != undefined && message.length > 0){
                        $(this).find('.modal-body h4').text(message);
                    }
                }
            });

            <?php
            if ($AppRendererHelper->getModalMessage()): ?>
            $('#modalMessage').modal('show');
            <?php endif; ?>
        });
    </script>

<?php
if ($FooterData != null)
    foreach ($FooterData as $data):
        require_once __DIR__.'/data/'.$data.'.php';
    endforeach; ?>

<?php
if ($FooterScripts != null)
foreach ($FooterScripts as $script):?>
    <script src="/assets/js/<?=$script?>.js?<?=\Zelfi\Config\Config::CURRENT_VERSION_CODE?>"></script>
<?php endforeach; ?>
</body>
</html>
