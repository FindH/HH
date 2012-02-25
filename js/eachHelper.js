(function ($) {

    $("#leaveComment").hide();
    /* Gömmer lämna kommentarformuläret så att den endst visas om man faktiskt väljer att lämna en kommentar! */

    $('#leaveCommentButton').click(function () {
        $("#leaveCommentButton").slideUp();
        $("#leaveComment").slideDown();
        /* return false; */
    });

    /*    */
    $(".disappointed").hide();
    /* Gömmer lämna kommentarformuläret så att den endst visas om man faktiskt väljer att lämna en kommentar! */

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
    /* Gömmer contactForm så att den endst visas om man faktiskt väljer att höra av sig. */

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