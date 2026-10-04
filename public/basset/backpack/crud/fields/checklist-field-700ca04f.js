function bpFieldInitChecklist(element) {
    let hidden_input = element.find('input[type=hidden]');
    let selected_options = JSON.parse(hidden_input.val() || '[]');
    let container = element.find('.row.checklist-options-container');
    let checkboxes = container.find(':input[type=checkbox]');                
    let showSelectAll = hidden_input.data('show-select-all');
    let selectAllAnchor = element.find('.checklist-select-all-inputs').find('a.select-all-inputs');
    let unselectAllAnchor = element.find('.checklist-select-all-inputs').find('a.unselect-all-inputs');

    // set the default checked/unchecked states on checklist options
    checkboxes.each(function(key, option) {
      var id = $(this).val();

      if (selected_options.map(String).includes(id)) {
        $(this).prop('checked', 'checked');
      } else {
        $(this).prop('checked', false);
      }
    });

    // when a checkbox is clicked
    // set the correct value on the hidden input
    checkboxes.click(function() {
      var newValue = [];

      checkboxes.each(function() {
        if ($(this).is(':checked')) {
          var id = $(this).val();
          newValue.push(id);
        }
      });

      hidden_input.val(JSON.stringify(newValue)).trigger('change');

      toggleAllSelectAnchor();
    });
      
    let selectAll = function() {
      checkboxes.prop('checked', 'checked');
      hidden_input.val(JSON.stringify(checkboxes.map(function() { return $(this).val(); }).get())).trigger('change');
      selectAllAnchor.toggleClass('d-none');
      unselectAllAnchor.toggleClass('d-none');
    };

    let unselectAll = function() {
      checkboxes.prop('checked', false);
      hidden_input.val(JSON.stringify([])).trigger('change');
      selectAllAnchor.toggleClass('d-none');
      unselectAllAnchor.toggleClass('d-none');
    };

    let toggleAllSelectAnchor = function() {
      if(showSelectAll === false) {
        return;
      }

      if (checkboxes.length === selected_options.length) {
        selectAllAnchor.toggleClass('d-none');
        unselectAllAnchor.toggleClass('d-none');
      }
    };

    if(showSelectAll) {
      selectAllAnchor.click(selectAll);
      unselectAllAnchor.click(unselectAll);

      toggleAllSelectAnchor();
    }

    hidden_input.on('CrudField:disable', function(e) {
          checkboxes.attr('disabled', 'disabled');
      });

    hidden_input.on('CrudField:enable', function(e) {
        checkboxes.removeAttr('disabled');
    });

}

        