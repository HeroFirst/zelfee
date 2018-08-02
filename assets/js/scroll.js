/**
 * Created by osman on 18.12.2016.
 */
$(document).ready(function(){
    $('.go_to').click( function(){ // ловим клик по ссылке с классом go_to
        var scroll_el = $(this).attr('href'); // возьмем содержимое атрибута href, должен быть селектором, т.е. например начинаться с # или .
        if ($('.col-xs-12').hasClass('sticky')){
        if ($(scroll_el).length != 0) { // проверим существование элемента чтобы избежать ошибки
            $('html, body').animate({scrollTop: $(scroll_el).offset().top-60}, 500); // анимируем скроолинг к элементу scroll_el $(scroll_el).offset().top
        }}
        else{
            if ($(scroll_el).length != 0) { // проверим существование элемента чтобы избежать ошибки
                $('html, body').animate({scrollTop: $(scroll_el).offset().top-120}, 500); // анимируем скроолинг к элементу scroll_el $(scroll_el).offset().top
            }
        }

        return false; // выключаем стандартное действие
    });
    $(document).on("scroll", onScroll);

    $('.go_to').click(function(e){
        e.preventDefault();
        $(document).off("scroll");
        $(menu_selector + " a.active").removeClass("active");
        $(this).addClass("active");
    });

});

(function(){  // анонимная функция (function(){ })(), чтобы переменные "a" и "b" не стали глобальными
    var a = document.querySelector('#aside1'), b = document.querySelector('.col-xs-12');  // селектор блока, который нужно закрепить
    window.addEventListener('scroll', Ascroll, false);
    document.body.addEventListener('scroll', Ascroll, false);  // если у html и body высота равна 100%
    function Ascroll() {
        if (a.getBoundingClientRect().top <= 0) { // elem.getBoundingClientRect() возвращает в px координаты элемента относительно верхнего левого угла области просмотра окна браузера
            $('#aside1 .col-xs-12').addClass('sticky');
        } else {
            $('#aside1 .col-xs-12').removeClass('sticky');
        }

    }
})();

var menu_selector = "#top-menu";

function onScroll(){
    var scroll_top = $(document).scrollTop();
    $(menu_selector + " a.go_to").each(function(){
        var hash = $(this).attr("href");
        var target = $(hash);

        if (target.position().top -100<= scroll_top &&
            target.position().top + target.outerHeight() -100 > scroll_top) {
            $(menu_selector + " a.active").removeClass("active");
            $(this).addClass("active");
        } else {
            $(this).removeClass("active");
        }
    });
}