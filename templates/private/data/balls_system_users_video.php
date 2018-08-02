<script>
    $(document).ready(function(){
        $('#modalRemove').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);

            var user_video_name = button.data('user-video-name');
            var user_video_id = button.data('user-video-id');
            var user_id = button.data('user-id');

            var modal = $(this);
            modal.find('.modal-body p').text('Удалить видео: ' + user_video_name + '?');
            modal.find('.modal-footer input[name=user_video_id]').val(user_video_id);
            modal.find('.modal-footer input[name=user_id]').val(user_id);
        });

        $('#modalApprove').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);

            var user_video_name = button.data('user-video-name');
            var user_video_id = button.data('user-video-id');
            var user_id = button.data('user-id');

            var modal = $(this);
            modal.find('.modal-body p').text('Подтвердить видео: ' + user_video_name + '?');
            modal.find('.modal-footer input[name=user_video_id]').val(user_video_id);
            modal.find('.modal-footer input[name=user_id]').val(user_id);
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
                <form id="formRemove" method="post" action="/private/balls-system/bonuses/users-video/remove">
                    <input type="hidden" name="user_video_id" value="">
                    <input type="hidden" name="user_id" value="">
                </form>
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Отменить</button>
                <button form="formRemove" type="submit" class="btn btn-outline">Удалить</button>
            </div>
        </div>

    </div>

</div>

<div class="modal modal-warning fade" id="modalApprove" tabindex="-1" role="dialog">
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
                <form id="formApprove" method="post" action="/private/balls-system/bonuses/users-video/approve">
                    <input type="hidden" name="user_video_id" value="">
                    <input type="hidden" name="user_id" value="">
                </form>
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Отменить</button>
                <button form="formApprove" type="submit" class="btn btn-outline">Подтвердить</button>
            </div>
        </div>

    </div>

</div>