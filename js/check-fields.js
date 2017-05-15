/**
 * Created by Alex on 15/05/2017.
 */
$(document).ready(function () {
    var btn = document.getElementById('upload-post');
    var title = false;
    var desc = false;
    var topics = false;
    var pic = false;

    function checkIfFilledIn() {
        if (title && desc && topics && pic){
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    }

    function x (obj) {
        if (obj.val() == ""){
            $(obj).css('border','1.5px solid firebrick');
            title = false;
        } else {
            $(obj).css('border','1.5px solid #b3b3b3');
            title = true;
        }
    }

    $('#fileToUpload').on('change',function () {
        if ($('#fileToUpload').val() != ""){
            pic = true;
        } else {
            pic = false;
        }
        checkIfFilledIn();
    })


    $('.rendered-images').on('click', 'img', function () {
        if($('#rendered-url').val() != ""){
            pic = true;
        } else {
            pic = false;
        }
        checkIfFilledIn()
    });


    $('#title').on('change', function () {
        x($(this));
        checkIfFilledIn();
    });

    $('#title').on('blur', function () {
        x($(this));
        checkIfFilledIn();
    })

    $('textarea[name=Description]').on('keyup', function () {
        if ($(this).val() == ""){
            $(this).css('border','1.5px solid firebrick');
            desc = false;
        } else {
            $(this).css('border','1.5px solid #b3b3b3');
            desc = true;
        }
        checkIfFilledIn();
    });

    $('.box_topics').on('click', 'label', function () {
        if($(this).children().val() == ""){
            topics = false;
        } else {
            topics = true;
        };
        checkIfFilledIn();
    })
})