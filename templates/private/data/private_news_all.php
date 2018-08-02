<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.13/sorting/datetime-moment.js"></script>
<script>

    $(document).ready(function(){
        $.fn.dataTable.moment( 'YYYY-MM-DD hh:mm:ss' );

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