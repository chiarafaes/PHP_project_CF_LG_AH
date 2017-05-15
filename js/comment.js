$(document).ready(function () {
    $("#btnSubmit").on("click", function (e) {
        e.preventDefault();

        //text vak uitlezen
        var comment = $("#comment").val();
        var postID = $('#post-id').val();

        // via ajax comment naar de DB sturen
        $.ajax({
            url: "ajax/ajax.comment.php",
            method: "post",
            data:{comment: comment, postID: postID}  //update: en postID= naam en comment en postID= waarde (value)
        })
        .done(function( response ) {

            console.log(response);
            //code+message
            if (response.code == 200){

                console.log('success');

                //iets plaatsen
                var div = $('<div class="comment" style="display: none;"></div>');

                div.html("<a href='profilepage_follower.php?profile=" + response.email + "' ><img id='avatar' src='" + response.avatar + "' /></a>" + "<div class='comment_zelf'>" + "<a href='profilepage_follower.php?profile=" + response.email + "'>" + response.user + ":</a> " + "<p>" + response.message + "</p></div>");

                var deleteDiv =
                    '<div class ="verwijdercomment">'+
                    '<form method ="post" action="">'+
                    '<input type="hidden" name="commentId" value="'+ response.res +'">'+
                    '<input id="btnVerwijderC" type="submit" value="Verwijderen">'+
                    '</form>'+
                    '</div>';

                //waar plaatsen
                $("#listupdates").prepend(div);
                $("#listupdates div").first().after(deleteDiv);
                $("#listupdates div").first().slideDown();
                $("#comment").val("").focus();
            }
        });
    })
})

