function bpFieldInitRadioElement(element) {
    var hiddenInput = element.find('input[type=hidden]');
    var value = hiddenInput.val();
    var id = 'radio_'+Math.floor(Math.random() * 1000000);

    // set unique IDs so that labels are correlated with inputs
    element.find('.form-check input[type=radio]').each(function(index, item) {
        $(this).attr('id', id+index);
        $(this).siblings('label').attr('for', id+index);
    });

    hiddenInput.on('CrudField:disable', function(e) {
        element.find('.form-check input[type=radio]').each(function(index, item) {
            $(this).prop('disabled', true);
        });
    });

    hiddenInput.on('CrudField:enable', function(e) {
        element.find('.form-check input[type=radio]').each(function(index, item) {
            $(this).removeAttr('disabled');
        });
    });

    // when one radio input is selected
    element.find('input[type=radio]').change(function(event) {
        // the value gets updated in the hidden input and the 'change' event is fired
        hiddenInput.val($(this).val()).change();
        // all other radios get unchecked
        element.find('input[type=radio]').not(this).prop('checked', false);
    });

    // select the right radios
    element.find('input[type=radio]').filter(function() {
        return $(this).val() === value;
    }).prop('checked', true);
}

    