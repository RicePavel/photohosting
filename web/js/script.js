

$(document).ready(function() {
    $('.delete_form').on('beforeSubmit', function() {
        return confirm('Подтвердите удаление');
    });
    
    $('#multipleDeleteForm').hide();
    $('#multipleDeleteForm').on('beforeSubmit', function() {
        return confirm('Подтвердите удаление');
    });
    $('.multipleDeleteInput').change(function() {
        var length = $('.multipleDeleteInput:checked').length;
        if (length > 0) {
            $('#multipleDeleteForm').show();
        } else {
            $('#multipleDeleteForm').hide();
        }
        if ($(this).prop('checked')) {
            $(this).closest('.indexImageDiv').addClass('selected');
        } else {
            $(this).closest('.indexImageDiv').removeClass('selected');
        }
    });
    
});


