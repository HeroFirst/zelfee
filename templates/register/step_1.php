<?php include __DIR__.'/../header-simple.php'; ?>

        <div class="page-content">
            <div class="container">
                <div class="row margin-top-40">
                    <div class="col-xs-12">
                        <div class="box-title-page">
                            <h1>Регистрация</h1>
                        </div>
                    </div>
                </div>
                <div class="row margin-top-20">
                    <div class="col-xs-12">
                        <div class="register-top-banner">
                            <img src="/assets/images/banner_register.png" />
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

                        <form id="form-registration-step-1" action="/registration/step/1" method="post" class="form-horizontal">
                            <div class="form-group">
                                <label for="first_name" class="col-sm-3 control-label">Имя</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Ваше имя" required>
                                </div>
                            </div>

                            <div class="form-group margin-top-30">
                                <label for="last_name" class="col-sm-3 control-label">Фамилия</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Ваша фамилия" required>
                                </div>
                            </div>

                            <div class="form-group margin-top-30">
                                <label for="email" class="col-sm-3 control-label">E-mail</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="" required>
                                </div>
                            </div>

                            <div class="form-group margin-top-30">
                                <label for="password" class="col-sm-3 control-label">Пароль</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Пароль (мин 8 символов)" required>
                                </div>
                            </div>

                            <div class="form-group margin-top-30">
                                <label for="password_check" class="col-sm-3 control-label">Пароль</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password_check" name="password_check" placeholder="Подтверждение пароля" required>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="col-xs-1">
                        <div class="register-divider">
                            <div class="line"></div>
                            <div class="text">или</div>
                            <div class="line"></div>
                        </div>
                    </div>

                    <div class="col-xs-2">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="register-social-item">
                                    Вконтакте <a href="/auth/vk" class="social-icon social-icon-vk"></a>
                                </div>
                            </div>
                        </div>

                        <div class="row margin-top-30">
                            <div class="col-xs-12">
                                <div class="register-social-item">
                                    Facebook <a href="/auth/fb" class="social-icon social-icon-fb"></a>
                                </div>
                            </div>
                        </div>

                        <div class="row margin-top-30 hide">
                            <div class="col-xs-12">
                                <div class="register-social-item">
                                    Ok <a href="/auth/ok" class="social-icon social-icon-ok"></a>
                                </div>
                            </div>
                        </div>

                        <div class="row margin-top-30 hide">
                            <div class="col-xs-12">
                                <div class="register-social-item">
                                    Mail.ru <a href="/auth/mailru" class="social-icon social-icon-mail"></a>
                                </div>
                            </div>
                        </div>

                        <div class="row margin-top-30">
                            <div class="col-xs-12">
                                <div class="register-social-item">
                                    Google <a href="/auth/gplus" class="social-icon social-icon-gplus"></a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row margin-top-30">
                    <div class="col-xs-12">
                        <div class="checkbox">
                            <label>
                                <input form="form-registration-step-1" type="checkbox" name="agree_subscription" checked value="true">
                                Хочу получать новости проекта на почту
                            </label>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="checkbox">
                            <label>
                                <input form="form-registration-step-1" type="checkbox" name="agree_license" value="true" required>
                                Принимаю <a target="_blank" href="/terms">правила и условия соглашения</a>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-70">
                    <div class="col-xs-3">
                        <button type="submit" form="form-registration-step-1" class="button button-pink button-full-width">Регистрация</button>
                    </div>
                </div>

            </div>
        </div>

<?php include __DIR__.'/../footer.php' ?>