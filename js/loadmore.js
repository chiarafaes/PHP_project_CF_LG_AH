/**
 * Created by Alex on 17/04/2017.
 */

$(document).ready(function () {
    var offset = 0;
    $('#btn_loadmore').click(function (e) {
        e.preventDefault();
        offset += 5;
        $.ajax({
            url: 'ajax/ajax.loadmore.php',
            type: 'post',
            data: {'offset': offset},
            success: function (data) {
                data.forEach(function (value) {
                    var post = '<div class="pin">'+
                        '<div class="img_holder">'+
                        '<div class="buttons" id="1">'+
                        '<a href="#" class="btn send">Send</a>'+
                        '<a href="#" class="btn save">Save</a>'+
                        '<a href="#" class="btn like">'+
                        '<img src="img/like_icon.svg" />'+
                        '</a>'+
                        '</div>'+
                        '<a class="image ajax" href="#" title="photo 1" id="1">'+
                        '<img src="'+value.picture+'" alt="" >'+
                        '</a>'+
                        '</div>'+
                        '<p class="description">'+value.description+'</p>'+
                        '<p class="info"><span>0</span></p>'+
                        '<hr>'+
                        '<div class="user_info">'+
                        '<img src="#" alt="#">'+
                        '<p>'+value.username+'</p>'+
                        '<p class="categorie">Categorie</p>'+
                        '</div>'+
                        '</div>';

                    $('#left').append(post);
                })
            },
            error : function () {
                alert("oei niet goed");
            }
        })
    })
});