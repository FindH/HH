(function ($) {

    $("#leaveComment").hide();
    /* G�mmer l�mna kommentarformul�ret s� att den endst visas om man faktiskt v�ljer att l�mna en kommentar! */

    $('#leaveCommentButton').click(function () {
        $("#leaveCommentButton").slideUp();
        $("#leaveComment").slideDown();
        /* return false; */
    });

    /*    */
    $(".disappointed").hide();
    /* G�mmer l�mna kommentarformul�ret s� att den endst visas om man faktiskt v�ljer att l�mna en kommentar! */

    $('.happy').click(function () {
        $(".satisfied").show();
        $(".disappointed").hide();
        $('.happy').addClass("markedSmiley");
        $('.angry').removeClass("markedSmiley");
        /* return false; */
    });

    $('.angry').click(function () {
        $(".satisfied").hide();
        $(".disappointed").show();
        $('.angry').addClass("markedSmiley");
        $('.happy').removeClass("markedSmiley");
        /* return false; */
    });

    $("#contactForm").hide();
    /* G�mmer contactForm s� att den endst visas om man faktiskt v�ljer att h�ra av sig. */

    $('#contactImage').click(function () {
        $("#contactImage").hide();
        $("#contactText").hide();
        $("#contactForm").slideDown('slow');
        return false;
    });

    $('#contactText').click(function () {
        $("#contactImage").hide();
        $("#contactText").hide();
        $("#contactForm").slideDown();
        return false;
    });

})(jQuery);