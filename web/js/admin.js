$(document).ready(function()
{
    $('[type=file]').bootstrapFileInput();

    var multiLangFields = $('.lang');
    multiLangFields.not('[data-lang=pl]').hide();

    $('.langs').on('click', 'a', function()
    {
        $('.langs a').fadeTo(100,'0.5');
        $(this).fadeTo(100, '1');
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

    $('.wysiwyg').wysihtml5();
    $().modal();

    $('body').on('click', '.glyphicon-trash', function()
    {
        if (!confirm('Potwierdź usunięcie'))
        {
            return false;
        }
    });
});