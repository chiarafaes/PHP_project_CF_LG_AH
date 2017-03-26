/**
 * Created by Alex on 26/03/2017.
 */
window.onload = function () {
    var pagenameHandler = document.getElementById('pagename');
    var pagenameContent = document.getElementsByClassName('is-side-bar-item-selected');
    var filler = pagenameContent[0].innerText;
    filler = filler.slice(0, filler.search('>')-1)

    if (pagenameContent.length == 1) {
        pagenameHandler.innerHTML = '<p>'+filler+'</p>';
    } else {
        pagenameHandler.innerHTML = 'ERROR: INVALID pagenamecontent';
    }
}