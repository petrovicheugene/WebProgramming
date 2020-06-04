(function ($, undefined) {
    $(document).ready(function () {

        $("img, title:contains(т)").each(function () {
            let currentImgHeight = $(this).height();
            if (currentImgHeight > 50 && currentImgHeight < 100) {
                $(this).css('border', 'solid #ff0000 1px');
            }
        });

    })();

})(jQuery)
