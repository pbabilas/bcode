$(document).ready(function()
{
    $('[type=file]').bootstrapFileInput();

    var multiLangFields = $('.lang');
    multiLangFields.not('[data-lang=pl]').hide();

    $('.langs').on('click', 'a', function()
    {
        var lang = $(this).data('src');

        multiLangFields.hide();

        multiLangFields.each(function()
        {
            var item = $(this);
            if (item.data('lang') == lang)
            {
                item.show();
            }
        });
        return false;
    });
});