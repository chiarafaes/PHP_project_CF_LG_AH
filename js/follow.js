$(document).ready(function(){
    $('.follow').click(function(){
    var $this = $(this);
    $this.toggleClass('follow');

    if($this.hasClass('follow')){
        $this.text('Follow');
    } else {
        $this.text('Following');
    }
}});
