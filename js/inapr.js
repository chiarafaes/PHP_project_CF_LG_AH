/**
 * Created by chiarafaes on 4/05/17.
 */

$(document).ready(function () {

    var report = $(".btnReport");

        report.on('click', function (e) {

            console.log(this.getAttribute("data-id")); // de id van de post in de console steken
            var id = this.getAttribute("data-id"); // de id van de post in de variabele id steken

            $.ajax(
                {
                    url:"ajax/ajax.markinappropriote.php",
                    method:"post",
                    data:{
                        "id": id
                    }
                }).done(function(response){
                    console.log(response); // de response uit ajax file in de console steken
                    document.getElementById("inappropriate").innerHTML = "dit is gerapporteerd!";
            })
            e.preventDefault();
        });
});