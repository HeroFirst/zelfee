<script>
    var phoneNumber;

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

            Digits.logIn({
                phoneNumber: '+7'
            })
                .done(onLogin)
                .fail(onLoginFailure);
        });
    });
</script>