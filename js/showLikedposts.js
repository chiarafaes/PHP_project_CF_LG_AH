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
                        '<div class="main_container_items">'+
                        '<div class="pin_"'+
                        '<div class="img_holder">'+
                        '<img class="img_container" src="'+likedposts[prop].picture+'" >'+
                        '</div>'+
                        '<p class="description_">'+likedposts[prop].title+' </p>'+
                        '<p class="likes_"> '+likedposts[prop].likes+' </p>'+
                        '</p>'+
                        '<p class="postdate_"> '+likedposts[prop].postdate+'</p>'+
                        '<p> '+likedposts[prop].location+' </p>'+
                        '</div>'+
                        '</div>';



                    container.append(pin);
                }

            },
            error: function () {
                console.log('could not get Liked posts');
            }
        })
    })
})