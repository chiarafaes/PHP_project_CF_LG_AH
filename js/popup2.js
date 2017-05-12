/**
 * Created by chiarafaes on 3/05/17.
 */
$(document).ready(function() {
    console.log('text')
    $('#modalOverlay').addClass('fadeInbg50');
    $('#content').addClass('fadeIn100');

    $("#content").click(function() {
        $('#modalOverlay').hide();
    });

    // $('#new_post').on('click' ,function (e) {
    //     e.preventDefault();
    //     post = $(this).parent().parent().parent().attr('id').substr(6);
    //
    //     $('#save_to_collection').fadeIn('fast');
    //     $('#save_to_collection_content').fadeIn('fast');
    // });

});



