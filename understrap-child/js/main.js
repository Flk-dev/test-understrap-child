(function ($) {
    $(document).ready(function () {
        // Callback
        $('.form').on('click', 'button', function(e){
            e.preventDefault();
            let form = $(this).closest('form');

            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();

            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: form.serialize() + '&action=save_real_state',
                type:'POST',
            }).done(function(result){
                if (result.success == false && result.data.errors){
                    $.each(result.data.errors, function(e, index) {
                        form.find('input[name="'+e+'"], textarea[name="'+e+'"]').addClass('is-invalid');
                        form.find('input[name="'+e+'"], textarea[name="'+e+'"]').parent().append('<div class="invalid-feedback">'+index[0]+'</div>');
                    });
                } else {
                    form.find('.form__message').slideDown().text(result.data.message);
                    form[0].reset();
                }
            });
        });
    });
})(jQuery);