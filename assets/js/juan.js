document.querySelector("html").classList.add('js');



var fileInput = document.querySelector(".input-file"),

    button = document.querySelector(".input-file-trigger"),

    the_return = document.querySelector(".file-return-input");



button.addEventListener("keydown", function(event) {

    if (event.keyCode == 13 || event.keyCode == 32) {

        fileInput.focus();

    }

});

button.addEventListener("click", function(event) {

    fileInput.focus();

    return false;

});

fileInput.addEventListener("change", function(event) {

    //inputNode.value = fileInput.value.replace("C:\\fakepath\\", "");

    the_return.value = this.value.replace("C:\\fakepath\\", "");



});



$('#TdeFMap').height($(window).height());



$("#enviarReporte").click(function(event) {

    event.preventDefault();



    var error = false;



    if (!error) {

        $('form').submit();

        return true;

    }

});




$(".custom-select").each(function() {

    var classes = $(this).attr("class"),

        id = $(this).attr("id"),

        name = $(this).attr("name");

    var template = '<div class="' + classes + '">';

    template += '<span class="custom-select-trigger">' + $(this).attr("placeholder") + '</span>';

    template += '<div class="custom-options">';

    $(this).find("option").each(function() {

        template += '<span class="custom-option ' + $(this).attr("class") + '" data-value="' + $(this).attr("value") + '"><span class="dots dot-' + $(this).attr("value") + '"></span>' + $(this).html() + '</span>';

    });

    template += '</div></div>';



    $(this).wrap('<div class="custom-select-wrapper"></div>');

    $(this).hide();

    $(this).after(template);

});

$(".custom-option:first-of-type").hover(function() {

    $(this).parents(".custom-options").addClass("option-hover");

}, function() {

    $(this).parents(".custom-options").removeClass("option-hover");

});

$(".custom-select-trigger").on("click", function(event) {

    $('html').one('click', function() {

        $(".custom-select").removeClass("opened");

    });

    $(this).parents(".custom-select").toggleClass("opened");

    event.stopPropagation();

});

$(".custom-option").on("click", function() {

    $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));

    $(this).parents(".custom-options").find(".custom-option").removeClass("selection");

    $(this).addClass("selection");

    $(this).parents(".custom-select").removeClass("opened");

    $(this).parents(".custom-select").find(".custom-select-trigger").text($(this).text());

});



$('.form-error-pop-up').height(($(window).height()) - $('#cargarReporte h3').height()).css('marginTop', $('#cargarReporte h3').height());;
