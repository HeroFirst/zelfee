<?php require_once __DIR__.'/../header.php' ?>
<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *  @var \Zelfi\Model\ZFCities $AppCities
 */
if ($AppRendererHelper != null){
    $FooterScripts = $AppRendererHelper->getFooterScripts();
    $FooterData = $AppRendererHelper->getFooterData();
}

?>

<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-info"></i> Внимание!</h4>
    Пароль будет отправлен по указанной почте
</div>

<form id="form-place-add" action="/private/users/new" method="post" class="form-horizontal">
    <div class="form-group">
        <div class="col-md-4">
            <input type="text" class="form-control" name="first_name" placeholder="Имя" required>
        </div>

        <div class="col-md-4">
            <input type="text" class="form-control" name="last_name" placeholder="Фамилия" required>
        </div>

        <div class="col-md-4">
            <select name="role" class="form-control select2" required>
                <?php if ($roles) foreach ($roles as $index => $role):
                    if ($role['id'] > $AppUser->getRole()):?>
                        <option <?=($role['id'])==5 ? 'selected': ''?> value="<?=$role['id']?>"><?=$role['name']?></option>
                <?php endif;
                endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-4">
            <input type="email" class="form-control" name="email" placeholder="Email">
        </div>

        <div class="col-md-4">
            <div class="input-group">
                <input type="tel" class="form-control" name="phone" placeholder="Номер телефона">
                <div class="input-group-btn">
                    <button id="phone_check" type="button" class="btn btn-success">Подтвердить</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <select name="city" class="form-control select2" required>
                <option value="" disabled selected>Выберите город</option>
                <?php if ($AppCities) foreach ($AppCities->getCities() as $index => $item): ?>
                    <div class="col-md-12">
                        <option value="<?=$item['id']?>"><?=$item['name']?></option>
                    </div>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3">
            <input <?=($_GET['rfidid'] ? 'value="'.$_GET['rfidid'].'"' : '')?> type="text" class="form-control" name="rfidid" placeholder="RFIDID">
        </div>
        <div class="col-md-9">
            <input type="text" class="form-control" name="description" placeholder="Описание">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3">
            <div class="form-group">
                <label for="kids_count" class="col-md-4 control-label">Дети</label>
                <div class="col-md-8">
                    <select id="kids_count" class="form-control">
                        <option disabled selected>Нет</option>
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

    <div class="row margin-top-30 childs-container">

    </div>

    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary pull-right">Добавить</button>
        </div>
    </div>

</form>

<?php require_once  __DIR__.'/../footer.php' ?>
