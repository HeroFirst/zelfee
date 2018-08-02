<script>
    $(document).ready(function(){
        $('#modalFinish').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);

            var order_id = button.data('order-id');

            var modal = $(this);
            modal.find('.modal-body p').text('Завершить заказ #' + order_id + '?');
            modal.find('.modal-footer input[name=order_id]').val(order_id);
        });

        $('#modalRemove').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);

            var order_id = button.data('order-id');

            var modal = $(this);
            modal.find('.modal-body p').text('Удалить заказ #' + order_id + '?');
            modal.find('.modal-footer input[name=order_id]').val(order_id);
        });

        $('.data-table-full').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Russian.json"
            },
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });

        $(".select2").select2();
    });
</script>

<div class="modal modal-danger fade" id="modalRemove" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Внимание</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <form id="formRemove" method="post" action="/private/store/orders/remove">
                    <input type="hidden" name="order_id" value="">
                </form>
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Отменить</button>
                <button form="formRemove" type="submit" class="btn btn-outline">Удалить</button>
            </div>
        </div>

    </div>

</div>

<div class="modal modal-warning fade" id="modalFinish" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Внимание</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <form id="formFinish" method="post" action="/private/store/orders/finish">
                    <input type="hidden" name="order_id" value="">
                </form>
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Отменить</button>
                <button form="formFinish" type="submit" class="btn btn-outline">Подтвердить</button>
            </div>
        </div>

    </div>

</div>