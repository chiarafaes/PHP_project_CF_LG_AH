$(document).ready(function () {
    $("#btnSubmit").on("click", function (e) {

        //text vak uitlezen
        var comment = $("#comment").val();
        var postID = document.getElementById("post").getAttribute("data-id");

        // via ajax comment naar de DB sturen
        $.ajax({
            method: "POST",
            url: "ajax/ajax.comment.php",
            data:{update: comment, postID: postID}  //update: en postID= naam en comment en postID= waarde (value)
        })
            .done(function( response ) {
                //code+message
                if (response.code == 200){

                    //iets plaatsen
                    var li = $("<li style='display: none;'>");
                    li.html("<a href='http://localhost/PHP_project_cf_lg_ah/user_profile.php?user=" + response.email + "' ><img id='avatar' src='" + response.avatar + "' /></a>" + "   " + "  " + "<a href='http://localhost/PHP_project_cf_lg_ah/user_profile.php?user=" + response.email + "'>" + response.user + "</a>: " + response.message);

                    //waar plaatsen
                    $("#listupdates").prepend(li);
                    $("#listupdates li").first().slideDown();
                    $("#comment").val("").focus();
                }
            });

        e.preventDefault();
    })
})

