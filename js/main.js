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
// $('.btn__reg').on('click', function () {
//     var login = $('#inputEmail3').val(),
//         pas = $('#inputPassword3').val(),
//         pas2 = $('#inputPassword4').val();
//     $.post({
//         url: '../php/register.php',
//         data: {
//             login : login,
//             pas : pas,
//             pas2 : pas2
//         }
//     }).done(function (data) {
//          $('.register .form-horizontal').prepend(data);
//     });
// });

    // $('.auto').on('click', function () {
    //     var login = $('#inputEmail1').val(),
    //         pas = $('#inputPassword1').val();
    //     $.post({
    //         url: '../php/auto.php',
    //         data: {
    //             login : login,
    //             pas : pas
    //         }
    //     }).done(function (data) {
    //         $('.autorize .form-horizontal').prepend(data);
    //     });
    // });
    // $('.delBut').on('click', function () {
    //     var userID = $('input[name=userID]').val(),
    //         delBut = $('.delBut').val();
    //     $.post({
    //         url: '../php/show.php',
    //         data: {
    //             userID : userID,
    //             delBut : delBut
    //         }
    //     }).done(function (data) {
    //
    //     });
    // });
    // $('.delPic').on('click', function () {
    //     var logID = $('input[name=logID]').val(),
    //         delPic = $('.delPic').val();
    //     $.post({
    //         url: '../php/showphoto.php',
    //         data: {
    //             logID : logID,
    //             delPic : delPic
    //         }
    //     }).done(function (data) {
    //
    //     });
    // });

 // $('.save').on('click', function () {
 //     var file_data = $('#photo').prop('files')[0];
 //     var form_data = new FormData();
 //     form_data.append('photo', file_data);
 //     form_data.append('name', $('#name').val());
 //     form_data.append('age', $('#age').val());
 //     form_data.append('desc', $('#desc').val());
 //     $.post({
 //         url: '../php/profile.php',
 //         dataType: 'text',
 //         cache: false,
 //         contentType: false,
 //         processData: false,
 //         data: form_data
 //     }).done(function (data) {
 //         alert(data);
 //     });
 // });
});