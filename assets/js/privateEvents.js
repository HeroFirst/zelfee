/**
 * Created by slava on 11.11.2016.
 */

function getFileUploadBlock(index, name, val){
    return '<div class="image-add-box '+((val=='') ? 'image-add-box-empty': '')+'" id="image-add-box'+index+'">' +
        '<div class="square">' +
        '<div class="square-content">' +
        '<div class="overlay"></div> ' +
        '<div class="content" '+((val!='') ? 'style="background-image:url(' + val + ')"' : '')+'> ' +
        '<a class="image-add-box-add" href="#"> ' +
        '<span>Добавить<br />изображение</span> ' +
        '</a>' +
        '<a class="image-add-box-close" href="#">' +
        '<i class="fa fa-times"></i>' +
        '</a> ' +
        '<input type="hidden" value="'+val+'" name="'+name+'" required />' +
        '</div>' +
        '</div> ' +
        '</div>' +
        '</div>';
}

function elfinderDialog(context) {
    var fm = $('<div/>').dialogelfinder({
        url : '/Libraries/elfinder/connector.minimal.php',
        lang : 'ru',
        width : 840,
        height: 450,
        destroyOnClose : true,
        getFileCallback : function(files, fm) {
            console.log(files);
            context.invoke('editor.insertImage', fm.convAbsUrl(files.url));
        },
        commandsOptions : {
            getfile : {
                oncomplete : 'close',
                folders : false
            }
        }
    }).dialogelfinder('instance');
}

function openElFinderWithCallback(callback) {
    var fm = $('<div/>').dialogelfinder({
        url : '/Libraries/elfinder/connector.minimal.php',
        lang : 'en',
        width : 840,
        height: 450,
        destroyOnClose : true,
        getFileCallback : callback,
        commandsOptions : {
            getfile : {
                oncomplete : 'close',
                folders : false
            }
        }
    }).dialogelfinder('instance');
}

$(document).ready(function(){
    $('input[type=text].image-add-box').each(function (index) {
        $(this).replaceWith(getFileUploadBlock(index, $(this).attr('name'), $(this).val()));
    });

    $('.image-add-box').each(function (index) {
        var imageBox = $(this);
        var id = imageBox.attr('id');

        var content = $(this).find('.content');
        var buttonAdd = $(this).find('.image-add-box-add');
        var buttonRemove = $(this).find('.image-add-box-close');
        var inputText = $(this).find('input[type=hidden]');

        var classEmpty = 'image-add-box-empty';

        buttonAdd.click(function (e) {
            openElFinderWithCallback(
                function(files, fm) {
                    console.log(id);
                    imageBox.removeClass(classEmpty);
                    content.css('background-image', 'url('+fm.convAbsUrl(files.url)+')');
                    inputText.val(fm.convAbsUrl(files.url));
                }
            );

            e.preventDefault();
        });

        buttonRemove.click(function (e) {
            imageBox.addClass(classEmpty);
            content.css('background-image', 'none');
            inputText.val('');

            e.preventDefault();
        });
    });

    $('.textarea-summernote').summernote({
        height: 400,
        tabsize: 2,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['font', ['fontname', 'fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph', 'height']],
            ['insert', ['link', 'video', 'table', 'hr','elfinder']],
            ['misc', ['fullscreen', 'codeview', 'undo', 'redo', 'help']]
        ]
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

    $('#datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        language: 'ru'
    });

    $(".timepicker").timepicker({
        showInputs: false,
        showMeridian: false,
        showSeconds: true
    });

    $(".select2").select2();
});