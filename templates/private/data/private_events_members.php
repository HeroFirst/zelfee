<script>
    $(document).ready(function() {
        $('#modalRemove').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);

            var user_id = button.data('user-id');
            var user_name = button.data('user-name');
            var event_id = button.data('event-id');

            var modal = $(this);
            modal.find('.modal-body p').text('Удалить участника: ' + user_name + '?');
            modal.find('.modal-footer input[name=event_id]').val(event_id);
            modal.find('.modal-footer input[name=user_id]').val(user_id);
        });
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
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <form id="formRemove" method="post" action="/private/events/members/remove">
                    <input type="hidden" name="event_id" value="">
                    <input type="hidden" name="user_id" value="">
                </form>
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Отменить</button>
                <button form="formRemove" type="submit" class="btn btn-outline">Удалить</button>
            </div>
        </div>

    </div>

</div>