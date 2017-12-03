/**
 * Created by arku on 07.03.2017.
 */
console.log('Hello, World');
var selector = "div.starter-template>h1";

var zagolovok = $(selector);
var zagovol_data = zagolovok.html();
zagolovok.html('ahaha');

console.log(zagovol_data);

$('#returnback').on('click', function(){
    // zagolovok.html(zagovol_data)

    $.ajax({
        url: '/data.php',
        method: 'post',
        data: {
            superdata: zagovol_data //$_POST['superdata']
        }
    }).done(function (data) {
        var json = JSON.parse(data);  //JSON.stringify()
        var str = json.name + ' - ' + json.occupation + json.superdata;
        zagolovok.html(str)
    });
});
$(function () {
$('.btn__reg').on('click', function () {
    var login = $('#inputEmail3').val(),
        pas = $('#inputPassword3').val(),
        pas2 = $('#inputPassword4').val();
    $.post({
        url: '../php/register.php',
        data: {
            login : login,
            pas : pas,
            pas2 : pas2
        }
    }).done(function (data) {
         $('.register .form-horizontal').prepend(data);
    });
});

    $('.auto').on('click', function () {
        var login = $('#inputEmail1').val(),
            pas = $('#inputPassword1').val();
        $.post({
            url: '../php/auto.php',
            data: {
                login : login,
                pas : pas
            }
        }).done(function (data) {
            $('.autorize .form-horizontal').prepend(data);
        });
    });

 $('.save').on('click', function () {
     var name = $('#name').val(),
         age = $('#age').val(),
         desc = $('#desc').val();
     var file_data = $('#photo').get(0).files[0];
     var form_data = new FormData();
     $.ajax({
         url: '../php/profile.php',
         method: 'post',
         data: {
             name: name,
             age: age,
             desc: desc,
             photo: form_data.append('photo', file_data)
         },
         contentType: false,
         processData: false,
         cache: false
     }).done(function (data) {
         alert(data);
     });
 });
});