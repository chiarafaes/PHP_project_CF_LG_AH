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
                        '<div class="main_container_items">'+
                        '<div class="pin_"'+
                        '<div class="img_holder">'+
                        '<img class="img_container" src="'+PostedItem[prop].picture+'" >'+
                        '</div>'+
                        '<p class="description_">'+PostedItem[prop].title+' </p>'+
                        '<p class="likes_"> '+PostedItem[prop].likes+' </p>'+
                        '</p>'+
                        '<p class="postdate_"> '+PostedItem[prop].postdate+'</p>'+
                        '<p> '+PostedItem[prop].location+' </p>'+
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