/**
 * Created by Alex on 26/04/2017.
 */

$(document).ready(function ()
{

    $('#create-board').on('click', function()
    {

        var topics = [];
        $('.topicInput').each(function ()
        {

            if ($(this).val() == "on"){
                topics.push($(this).attr('id'))
            }

        });

        var name = $("#board-name").val();
        var private = $('#private').val();

        console.log(typeof private);

        $.ajax(
            {

            url: 'ajax/ajax.createboard.php',
            type: 'post',
            data:
                {
                    'name' : name,
                    'private' : private,
                    'topics' : topics
                },
            success: function (data) {
                console.log(data)
            }

        })
    })
})