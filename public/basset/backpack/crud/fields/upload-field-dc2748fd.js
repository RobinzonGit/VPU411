function bpFieldInitUploadElement(element) {
    var fileInput = element.find(".file_input");
    var fileClearButton = element.find(".file_clear_button");
    var fieldName = element.attr('data-field-name');
    var inputWrapper = element.find(".backstrap-file");
    var inputLabel = element.find(".backstrap-file-label");

    if(fileInput.attr('data-row-number')) {
      $('<input type="hidden" class="order_uploads" name="_order_'+fieldName+'" value="'+fileInput.data('filename')+'">').insertAfter(fileInput);

      var observer = new MutationObserver(function(mutations) {
        
        mutations.forEach(function(mutation) {
          if(mutation.attributeName == 'data-row-number') {                    
            let field = $(mutation.target);
            field = field.next('input[name="'+mutation.target.getAttribute('name')+'"]');
            field.attr('name', '_order_'+mutation.target.getAttribute('name'));
            field.val(mutation.target.getAttribute('data-filename'));                  
          }
        });
      });

      observer.observe(fileInput[0], {
        attributes: true,
      });
    }

    fileClearButton.click(function(e) {
        e.preventDefault();
        $(this).parent().addClass('d-none');
        // if the file input has a data-row-number attribute, it means it's inside a repeatable field
        // in that case, will send the value of the cleared input to the server
        if(fileInput.attr('data-row-number')) {
          $("<input type='hidden' name='_clear_"+fieldName+"' value='"+fileInput.data('filename')+"'>").insertAfter(fileInput);
          fileInput.siblings('.order_uploads').remove();
        }
        fileInput.parent().removeClass('d-none');
        fileInput.attr("value", "").replaceWith(fileInput.clone(true));

        // redo the selector, so we can use the same fileInput variable going forward
        fileInput = element.find(".file_input");

        // add a hidden input with the same name, so that the setXAttribute method is triggered
        $("<input type='hidden' name='"+fieldName+"' value=''>").insertAfter(fileInput);
    });

    fileInput.change(function() {
        var path = $(this).val();
        var path = path.replace("C:\\fakepath\\", "");
        inputLabel.html(path);
        // remove the hidden input
        $(this).next("input[type=hidden]").remove();
    });

    element.on('CrudField:disable', function(e) {
      element.children('.backstrap-file').find('input').prop('disabled', 'disabled');

      let $deleteButton = element.children('.existing-file').children('a.file_clear_button');

      if($deleteButton.length > 0) {
        $deleteButton.on('click.prevent', function(e) {
            e.stopImmediatePropagation();
            return false;
          });
          // make the event we just registered, the first to be triggered
          $._data($deleteButton.get(0), "events").click.reverse();
      }
  });

  element.on('CrudField:enable', function(e) {
    element.children('.backstrap-file').find('input').removeAttr('disabled');
    element.children('.existing-file').children('a.file_clear_button').unbind('click.prevent');
  });

}

  