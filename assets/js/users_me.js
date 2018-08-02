/**
 * Created by slava on 18.11.2016.
 */


function readURL(e) {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        $(reader).load(function (e) { $('#image').attr('src', e.target.result); });
        reader.readAsDataURL(this.files[0]);

        reader.onloadend = (function () {
            $('#openDialogImage').hide();

            $('#image').cropper({
                aspectRatio: 1,
                viewMode: 1,
                dragMode : 'none',
                zoomable : false,
                crop: function(e) {}
            });

            $('#saveImage').show();
        });
    }
}

function setStateButton(button, text, disabled) {
    $(button).text(text);
    $(button).attr('disabled', disabled);
}

$(document).ready(function(){
    $("#imageInput").change(readURL);

    $('#openDialogImage').click(function (e) {
        $("#imageInput").trigger('click');
    });

    $('#saveImage').click(function (e) {
        $('#image').cropper('getCroppedCanvas').toBlob(function (blob) {
            setStateButton('#saveImage', 'Сохранение...', true);

            var formData = new FormData();

            formData.append('cover', blob);

            $.ajax('/users/update/cover', {
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    window.location.replace("/users/me");

                },
                error: function () {
                    window.location.replace("/users/me");
                }
            });
        });
    });
    // frontend dynamic buttons feature
    var teammates=0;
    
    function check_btn_visibility() {
        if (teammates>0) {
            $('#btn_remove_teammate').show();
        } else {
            $('#btn_remove_teammate').hide();
        }
        if (teammates<4) {
            $('#btn_add_teammate').show();
        } else {
            $('#btn_add_teammate').hide();
        }
    }
    function add_teammate() {
        if (teammates<4) {
            $('#input-group').append('<input type=\'text\' style=\'margin-bottom:5px\'  name=\'teammate'+(teammates+1)+'\' placeholder=\'участник '+(teammates+1)+'\'>');
            makeInputAutocomplete(teammates+1)
            teammates++;
        }
        check_btn_visibility();
    }
    function remove_teammate() {
        if (teammates>0) {
            $('#input-group').children().last().remove();
            teammates--;
        }
        check_btn_visibility();
    }
    $('#btn_add_teammate').click(add_teammate);
    $('#btn_remove_teammate').click(remove_teammate);

    // autocomplete block
    function makeInputAutocomplete($id) {
        $.post('/autocomplete', function (data) {
            var users = JSON.parse(data)
            var fullNames = users.map(function (value) {
                return value['first_name']+' '+value['last_name']
            })
            $('input[name=teammate'+$id+']').autocomplete({
                source: fullNames
            })
        })
    }

})