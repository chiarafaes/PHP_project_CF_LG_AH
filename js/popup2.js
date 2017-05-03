/**
 * Created by chiarafaes on 3/05/17.
 */
$( document ).ready(function() {
    $('#modalOverlay').addClass('fadeInbg50');
    $('#content').addClass('fadeIn100');
});

$("#content").click(function() {
    $('#modalOverlay').hide();
});