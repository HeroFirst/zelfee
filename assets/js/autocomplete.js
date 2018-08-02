/**
 * Created by r.halikov on 19.01.2017.
 */

$(function () {
    $.post('/autocomplete', function (data) {
        var users = JSON.parse(data)
        var fullNames = users.map(function (value) {
            return value['first_name']+' '+value['last_name']
        })
        $('input[name=teammate1]').autocomplete({
                source: fullNames
            })
        })
        // fullNames.forEach(function (value, index) {
        //     $('ul').append('<li><a href='+index+'>'+value+'</a></li>')
        // })
    
    })
