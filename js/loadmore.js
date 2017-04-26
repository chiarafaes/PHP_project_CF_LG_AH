/**
 * Created by Alex on 17/04/2017.
 */

// zelfde functie als Post::getTimeAgo() maar dan in jQuery
function getTimeAgo(p_dDate)
{
    var currentDate = new Date();
    var postDate = new Date(p_dDate);
    var timeDiff = Math.abs(postDate.getTime() - currentDate.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    return diffDays;
}

$(document).ready(function () {
    var offset = 0;
    $('#btn_loadmore').click(function (e) {
        var likedPosts = [];
        var isLiked = '';
        e.preventDefault();
        offset += 20;
        $.ajax(
            {
            url: 'ajax/ajax.getlikedposts.php',
            type: 'post',
            success: function (data)
            {
                likedPosts = $.merge(likedPosts, data);
                $.ajax(
                    {
                    url: 'ajax/ajax.loadmore.php',
                    type: 'post',
                    data: {'offset': offset},
                    success: function (data)
                    {
                        data.forEach(function (value)
                        {
                            $.each(likedPosts, function (index, likedValue) {
                                if (value.id == likedValue.post){
                                    isLiked = '<img src="img/liked_icon.svg" />';
                                } else {
                                    isLiked = '<img src="img/like_icon.svg" />';
                                }
                            });
                            console.log();
                            var post = '<div class="pin" id="pinID-'+value.id+'">'+
                                '<div class="img_holder">'+
                                '<div class="buttons" id="1">'+
                                '<a href="#" class="btn send">Send</a>'+
                                '<a href="#" class="btn save">Save</a>'+
                                '<a href="#" class="btn like">'+
                                isLiked+
                                '</a>'+
                                '</div>'+
                                '<a class="image ajax" href="#" title="photo 1" id="1">'+
                                '<img src="'+value.picture+'" alt="" >'+
                                '</a>'+
                                '</div>'+
                                '<p class="description">'+value.title+'</p>'+
                                '<p class="likes"><span>'+value.likes+'</span></p>'+
                                '<p class="postdate"<span>'+getTimeAgo(value.postdate)+'d ago</span></p>'+
                                '<hr>'+
                                '<div class="user_info">'+
                                '<img src="'+value.avatar+'" alt="#">'+
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
            }
        })

    })
});