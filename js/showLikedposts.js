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

                var likedposts = value;

                for (var prop in likedposts){
                    if (likedposts[prop].private == 1){
                        var check = "checked"
                    } else {
                        check = ""
                    }
                    var pin =
                        '<div class="collection-container">'+
                            '<h1 class="collection-title">'+likedposts[prop].title+'</h1>'+
                        '</div>'+

                        '<div class="posts-container">'+
                            '<div class="pin"'+
                                '<div class="img_holder">'+
                                    '<img src="'+likedposts[prop].picture+'" >'+
                                '</div>'+
                                '<p class="description">'+likedposts[prop].description+' </p>'+
                                '<p class="icon_heart">'+
                                    '<img src="img/icon_hartjeLikes.svg">'+
                                    '<p> '+likedposts[prop].likes+' </p>'+
                                '</p>'+
                                '<p> '+likedposts[prop].postdate+'</p>'+
                                '<p> '+likedposts[prop].location+' </p>'+
                                '<div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+


                    container.append(pin);
                }

            },
            error: function () {
                console.log('could not get Liked posts');
            }
        })
    })
})