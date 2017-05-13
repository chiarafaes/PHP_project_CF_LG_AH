/**
 * Created by Alex on 7/05/2017.
 */
$(document).ready(function () {

    var post = '';
    var error = $('.error');
    var success = $('.success');

    $('.overlay').on('click', function (e) {
        e.preventDefault();
        $('.overlay').fadeOut('fast');
        $('#new_post').fadeOut('fast');
        $('#save_to_collection').fadeOut('fast');
        $('#save_to_collection_content').fadeOut('fast');
    })

    $('#login_pop').on('click',function (e) {
        e.preventDefault();
        $('.overlay').fadeIn('fast');
        $('#new_post').fadeIn('fast');
    });

    $('.likeable' +
        '' +
        '').on('click', '.save' ,function (e) {
        e.preventDefault();
        post = $(this).parent().parent().parent().attr('id').substr(6);
        $('.overlay').fadeIn('fast');
        $('#save_to_collection').fadeIn('fast');
        $('#save_to_collection_content').fadeIn('fast');
    });

    $('#save').on('click',function (e) {
        e.preventDefault();
        var board = $(this).siblings('input:checked').val()

        console.log(board)
        console.log(post)

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
                    $('#save_to_collection').fadeOut('fast');
                    $('#save_to_collection_content').fadeOut('fast');
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

})