/**
 * Created by chiarafaes on 9/05/17.
 */
/**
 * Created by chiarafaes on 8/05/17.
 */

$(document).ready(function () {
    var container = $('.main_container_profile');

    $('#btn_items').on('click', function () {
        console.log('voor ajax');
        $.ajax({
            url: 'ajax/ajax.GetPostedItems.php',
            type: 'post',
            data:{
                mode: 'items'
            },
            success: function (value) {
                console.log('got posts');
                console.log(value);
                container.html("");

                var PostedItem = value;

                for (var prop in PostedItem){
                    if (PostedItem[prop].private == 1){
                        var check = "checked"
                    } else {
                        check = ""
                    }
                    var pin =
                        '<div class="collection-container">'+
                        '<h1 class="collection-title">'+PostedItem[prop].title+'</h1>'+
                        '</div>'+
                        '<div class="posts-container">'+
                        '<div class="pin"'+
                        '<div class="img_holder">'+
                        '<img src="'+PostedItem[prop].picture+'" >'+
                        '</div>'+
                        '<p class="description">'+PostedItem[prop].description+' </p>'+
                        '<p class="icon_heart">'+
                        '<img src="img/icon_hartjeLikes.svg">'+
                        '<p> '+PostedItem[prop].likes+' </p>'+
                        '</p>'+
                        '<p> '+PostedItem[prop].postdate+'</p>'+
                        '<p> '+PostedItem[prop].location+' </p>'+
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