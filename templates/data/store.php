<?php
/**
 * @var Zelfi\Utils\RendererHelper $AppRendererHelper
 * @var \Zelfi\Model\ZFUser $AppUser
 *
 */

?>
<script>
    function updateResult(){

        var ballsInput = $('#modalStoreOrder input[name=balls]');
        var priceInput = $('#modalStoreOrder input[name=price]');
        var userZelfiInput = $('#modalStoreOrder input[name=user_zelfi]');
        var orderButton = $('#modalStoreOrder #storeOrder');

        var countInput = $('#modalStoreOrder input[name=count]');
        var currencySelect = $('#modalStoreOrder select[name=currency]');
        var resultTitle = $('#modalStoreOrder .result');

        var currency = currencySelect.val();
        var count = countInput.val();
        var balls = ballsInput.val();
        var userZelfi = userZelfiInput.val();
        var price = priceInput.val();

        if (count > 0){
            orderButton.attr('disabled', false);

            switch (currency){
                case '1':
                    var resultCount = balls * count;

                    if (resultCount <= userZelfi){
                        resultTitle.text(resultCount + ' ' +declOfNum(resultCount, ['зелфи', 'зелфи', 'зелфи']));
                        resultTitle.css('color', 'black');
                    } else {
                        resultTitle.text('Недостаточно Зелфи');
                        resultTitle.css('color', 'red');
                        orderButton.attr('disabled', true);
                    }
                    break;
                case '2':
                    resultCount = price * count;

                    resultTitle.css('color', 'black');
                    resultTitle.text(resultCount + ' ' +declOfNum(resultCount, ['рубль', 'рубля', 'рублей']));
                    break;
            }
        }

    }

    $(document).ready(function() {
        $('select').selectpicker();

        $('#modalStoreOrder').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);

            if (button != undefined){
                var id = button.data('store-item-id');
                var name = button.data('store-item-name');
                var description = button.data('store-item-description');
                var balls = button.data('store-item-balls');
                var price = button.data('store-item-price');
                var count = button.data('store-item-count');
                var cover = button.data('store-item-cover');

                var countInput = $(this).find('input[name=count]');
                var currencySelect = $(this).find('select[name=currency]');

                $(this).find('.title').text(name);
                $(this).find('.cover').css('background-image', 'url('+cover+')');
                $(this).find('input[name=balls]').val(balls);
                $(this).find('input[name=price]').val(price);
                $(this).find('input[name=item_id]').val(id);
                $(this).find('input[name=item_count]').val(count);

                countInput
                    .attr('max', count)
                    .val(1);
                currencySelect.val('1').change();

                countInput.on('keyup input', function () {
                    updateResult();
                });
                countInput.change(function() {
                    var max = parseInt($(this).attr('max'));
                    var min = parseInt($(this).attr('min'));
                    if ($(this).val() > max)
                    {
                        $(this).val(max);
                        updateResult();
                    }
                    else if ($(this).val() < min)
                    {
                        $(this).val(min);
                        updateResult();
                    }
                });
                countInput.keypress(function (e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        return false;
                    }
                });


                currencySelect.on('change', function () {
                    updateResult();
                });
            }

            updateResult();
        });
    });
</script>

<div class="modal zf-modal zf-modal-wide zf-modal-border-60 fade" id="modalStoreOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/images/icon_close.png"></button>
                <h4 class="modal-title" id="myModalLabel">Оформление покупки</h4>
            </div>
            <div class="modal-body">
                <div class="row margin-top-40">
                    <div class="col-md-12">
                            <div class="modal-store-order-container">

                                <div class="modal-store-order-container-info">
                                    <div style="background-image: url()" class="cover"></div>
                                    <div class="text">
                                        <div class="subtitle">
                                            Наименование
                                        </div>
                                        <div class="title"></div>
                                    </div>
                                </div>

                                <div class="modal-store-order-container-form margin-top-40">
                                    <form id="formStoreOrder" action="/store/order/new" method="post" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="currency" class="col-md-4">Оплата</label>
                                            <div class="col-md-6">
                                                <select name="currency" id="currency" required>
                                                    <option value="1">Зелфи</option>
                                                    <option value="2">Рублями</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group margin-top-20">
                                            <label class="col-md-4" for="count">Количество</label>
                                            <div class="col-md-6">
                                                <input id="count" name="count" type="number" value="1" min="1" max="100" step="1" required>
                                            </div>
                                        </div>

                                        <div class="form-group margin-top-50">
                                            <label class="col-md-4" for="email">Email</label>
                                            <div class="col-md-6">
                                                <input id="email" name="email" type="email" value="<?=$AppUser->getInfoItem('email')?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group margin-top-20">
                                            <label class="col-md-4" for="phone">Тел.</label>
                                            <div class="col-md-6">
                                                <input id="phone" name="phone" type="tel" value="<?=$AppUser->getInfoItem('phone')?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group margin-top-20">
                                            <label class="col-md-4">Итого</label>
                                            <div class="result col-md-8">
                                                0 зелфи
                                            </div>
                                        </div>

                                        <input type="hidden" name="item_id" value="">
                                        <input type="hidden" name="balls" value="" disabled>
                                        <input type="hidden" name="price" value="" disabled>
                                        <input type="hidden" name="item_count" value="" disabled>
                                        <input type="hidden" name="user_zelfi" value="<?=$AppUser->getInfoItem('zelfi')?>" disabled>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <button form="formStoreOrder" type="submit" id="storeOrder" class="button button-pink button-fixed-width margin-top-40">Оформить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>