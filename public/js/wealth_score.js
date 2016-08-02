$( document ).ready(function() {
    $('.grid').masonry({
        itemSelector: '.grid-item',
        gutter: 5
    });
    $('.collapse.in').prev('.panel-heading').addClass('active');
    $('#accordion, #bs-collapse')
        .on('show.bs.collapse', function(a) {
            $(a.target).prev('.panel-heading').addClass('active');
        })
        .on('hide.bs.collapse', function(a) {
            $(a.target).prev('.panel-heading').removeClass('active');
        });

    var color_array = ["#3498DB","#3CB371","#A52A2A","#d4ac0d","#1c2833"];
    var color_count = 0;

    $(".test-circle").each( function(){
        $(this).circliful({
            animationStep: 5,
            foregroundBorderWidth: 5,
            backgroundBorderWidth: 15,
            percent: $(this).children('input').val(),
            foregroundColor: color_array[color_count]
        });
        $(this).siblings(".panel-group").children(".panel").children(".panel-heading").css("background-color", color_array[color_count]);
        color_count++;
    });

// change size of item by toggling gigante class
    $('.panel-heading').click(function() {
        setTimeout(function(){$('.grid').masonry('layout')},500);
    });

    $('.idealsteps-nav').click(function() {
        $('.grid').masonry('layout');
    });


    $('.grid').masonry('layout');

});