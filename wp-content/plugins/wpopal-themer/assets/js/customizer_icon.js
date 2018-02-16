(function(a) {
    a(window).load(function() {
        a('div[id^="opal-radio-image-"]').each(function() {
            var b = a(this);
            b.id = b.attr("id").replace("radio-image-", "").replace("[", "-").replace("]", "");
            //alert(b.id);
            b.find(".opal-radio-image").click(function(event) {
                if (!a(this).hasClass("selected")) {
                    a(this).parent().children(".selected").removeClass("selected");
                    a(this).addClass("selected");
                    if (!a(this).children('input[type="radio"]').attr("checked")) {
                        a(this).children('input[type="radio"]').click();
                    }

                    wp.customize.bind( 'preview-ready', function () {
                        wp.customize.control(b.id).setting.set(a(this).children('input[type="radio"]').val());
                        //wp.customize.previewer.refresh();
                    });
                    event.preventDefault();
                }
            });
        });
    });
})(jQuery);
