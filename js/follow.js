$(document).ready(function () {
    $(".follow").on("click", function (e) {

        // via ajax naar de DB sturen
        $.ajax({
            method: "POST",
            url: "ajax/ajax.follow.php",
            data:{update: comment, postID: postID}  //update: en postID= naam en comment en postID= waarde (value)
        })
            .done(function( response ) {
                //code+message
                if (response.code == 200){

                    //iets plaatsen
                    var $this = $(this);
                    $this.toggleClass('follow');

                    if($this.hasClass('follow')){
                        $this.text('Follow');
                    } else {
                        $this.text('Following');
                    }
            });

        e.preventDefault();
    })
})


