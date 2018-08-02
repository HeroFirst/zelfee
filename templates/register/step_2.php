<?php include __DIR__.'/../header-simple.php'; ?>

        <div class="page-content">
            <form method="post" action="/registration/step/2">
                <div class="container">
                    <div class="row margin-top-40">
                        <div class="col-xs-12">
                            <div class="box-title-page">
                                <h1>Дополнительная информация</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-top-20 flex-container">
                        <div class="col-xs-4">

                            <div class="form-horizontal">

                                <div class="form-group margin-top-30">
                                    <label for="residence" class="col-sm-3 control-label">Город проживания</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="residence" name="residence" required>
                                            <?php foreach ($cities as $index => $city): ?>
                                                <option value="<?=$city['id']?>"><?=$city['name']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group margin-top-30 has-feedback">
                                    <label for="phone" class="col-sm-3 control-label">Телефон</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input style="padding-right: 0;" type="tel" name="phone" id="phone" placeholder="+7" class="form-control" required>
                                            <span class="input-group-btn">
                                                <button id="phone_check" type="button" class="btn btn-success btn-flat">Подтвердить</button>
                                            </span>
                                        </div>
                                       <!--
                                        <a href="#" id="phone_check">
                                            <span class="zf-icon zf-icon-feedback-true form-control-feedback" aria-hidden="true"></span>
                                        </a>
                                        -->
                                    </div>
                                </div>

                                <div class="form-group margin-top-10">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <label for="phone" class="control-label">На ваш номер телефона будет выслан код подтверждения</label>
                                    </div>
                                </div>

                                <div class="form-group margin-top-30">
                                    <label for="kids_toggle" class="col-sm-3 control-label">Дети</label>
                                    <div class="col-sm-9">
                                        <select id="kids_toggle" class="form-control">
                                            <option value="false">Нет</option>
                                            <option value="true">Есть</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row margin-top-50" data-dependency="kids_toggle">
                        <div class="col-xs-12">
                            <div class="box-title">
                                <h2>Информация о детях</h2>
                            </div>
                        </div>
                    </div>

                    <div class="row margin-top-20" data-dependency="kids_toggle">
                        <div class="col-xs-4">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label for="kids_count" class="col-sm-6 control-label">Сколько у вас детей</label>
                                    <div class="col-sm-6">
                                        <select id="kids_count" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row margin-top-30 childs-container" data-dependency="kids_toggle">


                    </div>

                    <div class="row margin-top-70">
                        <div class="col-xs-3">
                            <button disabled id="registration_step_2_submit" type="submit" class="button button-pink button-full-width">Завершить регистрацию</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>

<?php include __DIR__.'/../footer.php' ?>