/**
 * Created by Alex on 7/05/2017.
 */
$(document).ready(function () {

    var post = '';
    var error = $('.error');
    var success = $('.success');

    $('.likeable' +
        '' +
        '').on('click', '.save' ,function (e) {
            e.preventDefault();
            post = $(this).parent().parent().parent().attr('id').substr(6);

            $('#save_to_collection').fadeIn();
            $('#save_to_collection_content').css('visibility', 'visible');
    });

    $('#save').on('click',function (e) {
        e.preventDefault();
        var board = $(this).siblings('input:checked').val()

        $.ajax({
            url: 'ajax/ajax.add-to-collection.php',
            method: 'post',
            data:{
                'board': board,
                'post': post
            },
            success: function (value) {
                if (value == true){
                    console.log('Query gelukt');
                    $('#save_to_collection').fadeOut();
                    $('#save_to_collection_content').css('visibility', 'hidden');
                    success.text('Post opgeslagen!').slideDown().delay(1200).slideUp();

                } else if (value == false) {
                    console.log('Query mislukt');
                    error.text("Your post could not be saved.").fadeIn('fast')
                }
            },
            error: function (value) {
                console.log("Ajax niet gelukt");
            }
        })

    });

    $('.overlay').on('click',function (e) {
        e.preventDefault();
        $('#save_to_collection').fadeOut();
        $('#save_to_collection_content').css('visibility', 'hidden');
        error.fadeOut('fast')
    })

})