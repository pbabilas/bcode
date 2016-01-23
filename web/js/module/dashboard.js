$(document).ready(function()
{
    $('body').on('click', '.widget-add', function()
    {
        var item = $(this),
            href = item.attr('href'),
            overlay = $('<div class="overlay"> <i class="fa fa-refresh fa-spin"></i> </div>');;

        $.ajax({
            url: href,
            success: function(data)
            {
                $('#widgetsDashboard').replaceWith(data);
            }
        });
        $('#wigetModal').modal('hide')
        return false;
    });

    $('body').on('click', '.widget-delete', function()
    {
        var item = $(this),
            href = item.attr('href'),
            overlay = $('<div class="overlay"> <i class="fa fa-refresh fa-spin"></i> </div>');

        $('#widgetsDashboard').append(overlay);
        $.ajax({
            url: href,
            success: function(data)
            {
                $('#widgetsDashboard').replaceWith(data);

            }
        });
        return false;
    });
});