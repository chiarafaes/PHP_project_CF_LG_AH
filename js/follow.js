$(document).ready(function () {
    $("#btnFollow").on("click", function (e) {

        var userMail = $(this).attr("data-id");
        var action = $(this).attr("data-action");// follow of niet?

        $.ajax({
            method: "POST",
            url: "ajax/ajax.follow.php",
            data: {userMail:userMail, action:action}
        })
            .done(function(response){

                if(response.status == 'success') {
                    console.log('Success');

                    if (response.action == 'Follow') {
                        $("#btnFollow").val('Follow');
                        $("#btnFollow").attr('class', 'succes');
                        $("#btnFollow").attr('data-action', 'unfollow');

                    } else if (response.action != 'Follow') {
                        $("#btnFollow").val('Follow');
                        $("#btnFollow").attr('class', 'succes');
                        $("#btnFollow").attr('data-action', 'follow');

                    }
                }
            });
        e.preventDefault();
    });
})


