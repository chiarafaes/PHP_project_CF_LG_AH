/**
 * Created by chiarafaes on 4/05/17.
 */

$(document).ready(function () {

    var dislikesCounter = $('.dislikes').text()
    var report = $(".btnReport");

        report.on('click', function (e) {

            console.log(this.getAttribute("data-id")); // de id van de post in de console steken
            var id = this.getAttribute("data-id"); // de id van de post in de variabele id steken

            $.ajax(
                {
                    url:"ajax/ajax.markinappropriate.php",
                    method:"post",
                    data:{
                        "id": id
                    }
                }).done(function(response){
                    console.log(response); // de response uit ajax file in de console steken
                    document.getElementById("inappropriate").innerHTML = "dit is gerapporteerd!";
                    var newDislikes = parseInt($('.dislikes').text().substr(-1,1))+1;
                     $('.dislikes').text('dislikes : ' + newDislikes);
            })
            e.preventDefault();
        })
})