$('.follow').click(function (e) {
    e.preventDefault();

    $button = $(this);
    var follow_email = $(this).attr("rel");

    if ($button.hasClass('following')) {
        $.post('ajax/ajax.follow.php', {unfollow: follow_email});
        $button.removeClass('following');
        $button.removeClass('unfollow');
        $button.text('Follow');
    }
    else {
        $.post('ajax/ajax.follow.php', {follow: follow_email});
        $button.removeClass('follow');
        $button.addClass('following');
        $button.text('Following');
    }

}
