<?php
/* @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *  @var \Zelfi\Model\ZFCities $AppCities
 */

if ($AppRendererHelper != null){
    $FooterScripts = $AppRendererHelper->getFooterScripts();
    $FooterData = $AppRendererHelper->getFooterData();
}

require_once __DIR__.'/../header.php'
?>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li><a href="/private/store/orders/new">Новые</a></li>
                <li class="active"><a href="/private/store/orders/accepted">В процесе</a></li>
                <li><a href="/private/store/orders/finished">Завершенные</a></li>
            </ul>

            <div class="tab-content">
                <table class="table table-bordered table-striped data-table-full">
                    <thead>
                    <tr>
                        <th>ID заказа</th>
                        <th>ID товара</th>
                        <th>Товар</th>
                        <th>Количество</th>
                        <th>Валюта</th>
                        <th>Стоимость</th>
                        <th>Город</th>
                        <th>Покупатель</th>
                        <th>Дата заказа</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($orders) foreach ($orders as $index => $order): ?>
                        <tr>
                            <td><?=$order['id']?></td>
                            <td><?=$order['item_id']?></td>
                            <td><?=$order['info']['name']?></td>
                            <td><?=$order['count']?></td>
                            <td><?=$order['currency'] == 1 ? 'Баллы' : 'Рубли' ?></td>
                            <td><?=$order['currency'] == 1 ? ($order['info']['balls']*$order['count']) : ($order['info']['price']*$order['count']) ?></td>
                            <td><?=$AppCities->getCityById($order['user']['residence'])['name']?></td>
                            <td><?=$order['user']['first_name']?> <?=$order['user']['last_name']?></td>
                            <td><?=$order['date_created']?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button data-order-id="<?=$order['id']?>" data-toggle="modal" data-target="#modalFinish" type="button" class="btn btn-warning"><i class="fa fa-check"></i></button>
                                    <button data-order-id="<?=$order['id']?>" data-toggle="modal" data-target="#modalRemove" type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID заказа</th>
                        <th>ID товара</th>
                        <th>Товар</th>
                        <th>Количество</th>
                        <th>Валюта</th>
                        <th>Результат</th>
                        <th>Город</th>
                        <th>Покупатель</th>
                        <th>Дата заказа</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__.'/../footer.php' ?>
