<script id="digits-sdk" src="https://cdn.digits.com/1/sdk.js"></script>
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
    });

</script>
<script type="text/x-jsrender" id="templateChild">
    <div class="col-xs-4 {{:class}}">
        <div class="form-horizontal">
            <div class="form-group">
                <label for="kids[{{:index}}][gender]" class="col-sm-3 control-label">Пол</label>
                <div class="col-sm-9">
                    <select id="kids[{{:index}}][gender]" name="kids[{{:index}}][gender]" class="form-control" required>
                        <option value="1">Мальчик</option>
                        <option value="2">Девочка</option>
                    </select>
                </div>
            </div>
            <div class="form-group margin-top-30">
                <label for="kids[{{:index}}][first_name]" class="col-sm-3 control-label">Имя</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="kids[{{:index}}][first_name]" name="kids[{{:index}}][first_name]" placeholder="" required>
                </div>
            </div>
            <div class="form-group margin-top-30">
                <label for="kids[{{:index}}][age]" class="col-sm-3 control-label">Возраст</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" id="kids[{{:index}}][age]" name="kids[{{:index}}][age]" placeholder="" required>
                </div>
            </div>
        </div>
    </div>
</script>