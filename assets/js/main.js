var windowWidth = 0;

$(document).ready(function()
{
    $('.selector-fecha').datetimepicker({timepicker: false, format:'d-m-Y', lang: 'es'});

    $("html").addClass('js');

    //windowWidth = $(window).width();

    var fileInput = $(".input-file"),

        button = $(".input-file-trigger"),

        the_return = $(".file-return-input");

    button.on("keydown", function(event)
    {
        if (event.keyCode == 13 || event.keyCode == 32)
        {
            fileInput.focus();
        }
    });

    button.click(function(event)
    {
        fileInput.focus();

        return false;
    });

    fileInput.on("change", function(event)
    {
        the_return.val( $(this).val().replace("C:\\fakepath\\", ""));
    });

    $(document).on({
        mouseenter: function()
        {
            $(this).removeClass('collapse')
        },
        mouseleave: function()
        {
           $(this).addClass('collapse')
        }
    }, '#periodo, #status');

    $('.dropdown-menu input, .dropdown-menu label').click(function(e)
    {
        e.stopPropagation();
    });

    $("#enviarReporte").click(function(event)
    {
        event.preventDefault();

        var error = false;

        if (!error)
        {
            $('form').submit();

            return true;
        }
    });

    $('#volverReporte').click(function(event)
    {
        event.preventDefault();
        history.pushState('','','/');
        $('.form-pop-up').hide();
        event.stopPropagation();
    })

    $('.form-pop-up').click(function()
    {
        $('.form-pop-up').hide();
        history.pushState('','','/reportes/cargar');
    });

    //VAlidacion del form
    $('#cargarReporte').submit(function(e)
    {
        var error = false;

        //Campos
        var direccion = $('#direccion');
        var lat = $('#lat').val();
        var lng = $('#lng').val()

        if(direccion.val() == '')
        {
            hasError(direccion);
            error = true;
        }
        else
        {
            $(direccion).parent().removeClass('has-error');
            $(direccion).tooltip('destroy');
            direccion.removeClass('has-tooltip');
        }

        var zona = $('#zona_id');

        if(zona.val() == '')
        {
            hasErrorAlt(zona);
            error = true;
        }
        else
        {
            $(zona).parent().removeClass('has-error');
            $(zona).tooltip('destroy');
            zona.removeClass('has-tooltip');
        }

        var evento = $('#evento_id');

        if(evento.val() == '')
        {
            hasErrorAlt(evento);
            error = true;
        }
        else
        {
            $(evento).parent().removeClass('has-error');
            $(evento).tooltip('destroy');
            evento.removeClass('has-tooltip');
        }

        var comentarios = $('#comentarios');

        if(comentarios.val() == '')
        {
            hasError(comentarios);
            error = true;
        }
        else
        {
            $(comentarios).parent().removeClass('has-error');
            $(comentarios).tooltip('destroy');
            comentarios.removeClass('has-tooltip');
        }

        if(error)
        {
            e.preventDefault();
            return false;
        }
    });

    $(document).on('shown.bs.tooltip', '.has-tooltip', function ()
    {
        if ($(window).width() < 769)
        {
            $(this).tooltip('hide');
            $(this).removeClass('has-tooltip');
        }
    });

    //resposive();
    //$(window).trigger('resize');
});

$(window).resize(function()
{
    if (windowWidth != $(window).width())
    {
        //resposive();
        windowWidth = $(window).width();
    }
});

function hasErrorAlt(input)
{
    input = input.parent();
    input.tooltip({
        'trigger': 'manual',
        'title': 'Este campo es obligatorio',
        'placement': 'right'
    });

    input.addClass('has-tooltip');
    input.tooltip('show');

    input.parent().addClass('has-error');

    input.focus(function()
    {
        input.parent().removeClass('has-error');
        input.tooltip('destroy');
        input.removeClass('has-tooltip');
    });

    input.click(function()
    {
        input.parent().removeClass('has-error');
        input.tooltip('destroy');
        input.removeClass('has-tooltip');
    });
}

function hasError(input)
{
    input.tooltip({
        'trigger': 'manual',
        'title': 'Este campo es obligatorio',
        'placement': 'right'
    });

    input.addClass('has-tooltip');
    input.tooltip('show');

    input.parent().addClass('has-error');

    input.focus(function()
    {
        input.parent().removeClass('has-error');
        input.tooltip('destroy');
        input.removeClass('has-tooltip');
    });

    input.click(function()
    {
        input.parent().removeClass('has-error');
        input.tooltip('destroy');
        input.removeClass('has-tooltip');
    });
}

function resposive()
{
    var windowheight = $(window).height();

    $('.has-tooltip').tooltip('destroy');

    //if($(window).width() > 768)
    //{
        $('#TdeFMap, #form-carga').height(windowheight);
    //}
    //else
    //{
    //    $('#TdeFMap, #form-carga').height(windowheight / 1.6);
    //}
}

function openCalendar()
{
    $('#fecha-picker').focus();
}

$(function()
{
    $('#hora_reporte_picker').timepicker();
});
