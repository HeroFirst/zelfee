/**
 * Created by slava on 01.11.2016.
 */

var phoneNumber;

function updateKidsContainer() {
    if ( $('#kids_toggle').val() == 'true'){
        var items = [];

        for (i = 0;i<$('#kids_count').val();i++) {
            items.push({
                index: i,
                class :  ((i % 2 == 0) ? '' : ' col-md-offset-1') + ((i > 1) ? ' margin-top-60' : '')
            });
        }

        console.log(items);

        $('.childs-container').html($.templates("#templateChild").render(items));
    } else $('.childs-container').html('');
}

function onLogin(loginResponse){
    // Send headers to your server and validate user by calling Digits’ API
    var oAuthHeaders = loginResponse.oauth_echo_headers;
    var verifyData = {
        authHeader: oAuthHeaders['X-Verify-Credentials-Authorization'],
        apiUrl: oAuthHeaders['X-Auth-Service-Provider']
    };

    $.get( "/auth/callback/digits", verifyData, function( data ) {
        phoneNumber = JSON.parse(data).phone_number;

        $('input[name=phone]')
            .val(phoneNumber)
            .attr('readonly', true);

        $('#registration_step_2_submit').attr('disabled', false);
        $('#phone_check').hide();

    });
}

function onLoginFailure(loginResponse) {
    console.log('Digits login failed.');
}

$(document).ready(function(){
    Digits.init({ consumerKey: 'VJU8e4a1h449HImwMpO7X7cV6' });

    $('select').selectpicker();

    $('#phone_check').click(function () {
        phoneNumber = $('input[name=phone]').val();

        if (phoneNumber.length >= 10){
            Digits.logIn({
                phoneNumber: '+7' + phoneNumber.slice(-10)
            })
                .done(onLogin)
                .fail(onLoginFailure);
        }
    });

    $("div[data-dependency='kids_toggle']").each(function (e) {
        $(this).hide();
    });

    $('#kids_toggle').on('changed.bs.select', function (e) {
        var value = $(this).val();

        updateKidsContainer();

        $("div[data-dependency='kids_toggle']").each(function (e) {
            if (value=='true'){
                $(this).show(250);
            } else{
                $(this).hide(250);
            }
        });
    });

    $('#kids_count').on('changed.bs.select', function (e) {
        updateKidsContainer();
    });

    updateKidsContainer();
});