$(function() {

    var input = $('#fileUploadInput');

    //input.bootstrapFileInput();

    input.on('change', function()
    {
        input.closest('form').submit();
    });

    var form = $('#fileUploaderForm');
    var bar = $('.progress-bar');
    var percent = $('.percent');
    var status = $('#status');

    form.ajaxForm({
        beforeSend: function() {
            status.empty();
            var percentVal = '0%';
            bar.width(percentVal);
            bar.attr('aria-valuenow', 0);
            percent.html(percentVal);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
            bar.attr('aria-valuenow', percentComplete);
            percent.html(percentVal);
        },
        complete: function(xhr) {
            status.html(xhr.responseText);
        }
    });

    $('#pictureForm input, #pictureForm textarea').on('change', function()
    {
        var form = $(this).closest('form');

        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            type: 'POST',
            success: function()
            {

            }
        });
        return false;
    });

    $('#picture_wrapp').on('click', '.delete', function()
    {
        var item = $(this);
        $.ajax({
            url: item.attr('href'),
            type: 'GET',
            success: function(data)
            {
                $('#picture_wrapp').html(data);
                return false;
            }
        });
        return false;
    });

});