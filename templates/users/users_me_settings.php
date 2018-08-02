<?php /**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *
 */

include __DIR__.'/../header-simple.php'; ?>

    <div class="page-content">
        <div class="container">
            <div class="row margin-top-40">
                <div class="col-xs-12">
                    <div class="box-title-page">
                        <h1>Изменение информации</h1>
                    </div>
                </div>
            </div>

            <div class="row margin-top-30">
                <div class="col-xs-12">
                    <div class="box-title">
                        <h2>Основная информация</h2>
                    </div>
                </div>
            </div>

            <div class="row margin-top-20 flex-container">
                <div class="col-xs-4">

                    <form id="form-settings-info" action="/users/settings/info" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="first_name" class="col-sm-3 control-label">Имя</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="<?=$AppUser->getInfoItem('first_name')?>">
                            </div>
                        </div>

                        <div class="form-group margin-top-30">
                            <label for="last_name" class="col-sm-3 control-label">Фамилия</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="<?=$AppUser->getInfoItem('last_name')?>">
                            </div>
                        </div>

                        <div class="form-group margin-top-30">
                            <label for="email" class="col-sm-3 control-label">E-mail</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="<?=$AppUser->getInfoItem('email')?>">
                            </div>
                        </div>

                        <div class="form-group margin-top-30">
                            <label for="phone" class="col-sm-3 control-label">Номер телефона</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input readonly style="padding-right: 0;" type="tel" name="phone" id="phone" value="<?=$AppUser->getInfoItem('phone')?>" class="form-control">
                                    <span class="input-group-btn">
                                <button id="phone_check" type="button" class="btn btn-success btn-flat">Изменить</button>
                            </span>
                                </div>
                            </div> 
                        </div>
                        
                        <div class="form-horizontal">

                                <div class="form-group margin-top-30">
                                    <label for="residence" class="col-sm-3 control-label">Город проживания</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="residence" name="residence" required>
                                            <?php foreach ($AppCities->getCities() as $index => $city): ?>
                                                <option <?= ($AppUser->getInfoItem('residence') ==$city['id'] ? 'selected' : '' ) ?> value="<?=$city['id']?>"><?=$city['name']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                   
    
                        <div class="row margin-top-30">
                            <div class="col-xs-12">
                                <button type="submit" form="form-settings-info" class="button button-pink button-full-width">Сохранить</button>
                            </div>
                        </div>

                        </form>

                    <form id="form-settings-password" action="/users/settings/password" method="post" class="form-horizontal">

                        <div class="row margin-top-60">
                            <div class="col-xs-12">
                                <div class="box-title">
                                    <h2>Пароль</h2>
                                </div>
                            </div>
                        </div>

                        <div class="form-group margin-top-30">
                            <label for="password_check" class="col-sm-3 control-label">Новый пароль</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Пароль (мин 8 символов)" required>
                            </div>
                        </div>

                        <div class="form-group margin-top-30">
                            <label for="password_check" class="col-sm-3 control-label">Новый пароль</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password_check" name="password_check" placeholder="Подтверждение пароля" required>
                            </div>
                        </div>

                        <div class="row margin-top-30">
                            <div class="col-xs-12">
                                <button type="submit" form="form-settings-password" class="button button-pink button-full-width">Сохранить</button>
                            </div>
                        </div>

                        </form>

                    <form id="form-settings-subscribe" action="/users/settings/subscribe" method="post" class="form-horizontal">

                        <div class="row margin-top-60">
                            <div class="col-xs-12">
                                <div class="box-title">
                                    <h2>Подписка</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row margin-top-30">
                            <div class="col-xs-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="agree_subscription" <?=$subscription['subscribe'] ? 'checked' : '' ?> >
                                        Хочу получать новости проекта на почту
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row margin-top-30">
                            <div class="col-xs-12">
                                <button type="submit" form="form-settings-subscribe" class="button button-pink button-full-width">Сохранить</button>
                            </div>
                        </div>

                        </form>

                </div>

            </div>

        </div>
    </div>

<?php include __DIR__.'/../footer.php' ?>