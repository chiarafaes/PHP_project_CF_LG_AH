/**
 * Created by chiarafaes on 8/05/17.
 */

$(document).ready(function () {
    var container = $('.main_container_profile');

    $('#btn_likes').on('click', function () {
        console.log('voor ajax');
        $.ajax({
            url: 'ajax/ajax.getLikedPostsByUser.php',
            type: 'post',
            data:{
                mode: 'likes'
            },
            success: function (value) {
                console.log('got posts');
                console.log(value);
                container.html("");

                container.html(value);
            },
            error: function () {
                console.log('could not get Liked posts');
            }
        })
    })
})