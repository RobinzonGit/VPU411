function bpFieldInitSummernoteElement(element) {
     var summernoteOptions = element.data('options');

    let summernotCallbacks = {
        onChange: function(contents, $editable) {
            element.val(contents).trigger('change');
        },
    }

    if(element.data('upload-enabled') === true){
        let imageUploadEndpoint =  element.data('upload-endpoint') !== false ? element.data('upload-endpoint') : element.data('default-upload-url');
        let paramName = typeof element.attr('data-repeatable-input-name') !== 'undefined' ? element.closest('[data-repeatable-identifier]').attr('data-repeatable-identifier')+'#'+element.attr('data-repeatable-input-name') : element.attr('name');
        summernotCallbacks.onImageUpload = function(file) {
            var data = new FormData();
            data.append(paramName, file[0]);
            data.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            data.append('fieldName', paramName);
            data.append('operation', element.data('upload-operation'));

            var xhr = new XMLHttpRequest();
            xhr.open('POST', imageUploadEndpoint, true);
            xhr.setRequestHeader('Accept', 'application/json');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    var response = JSON.parse(xhr.responseText);
                    element.summernote('insertImage', response.data.filePath);
                } else {
                    var response = JSON.parse(xhr.responseText);
                    let errorBagName = paramName;
                    // it's in a repeatable field
                    if(errorBagName.includes('#')) {
                        errorBagName = errorBagName.replace('#', '.0.');
                    }
                    let errorMessages = typeof response.errors !== 'undefined' ? response.errors[errorBagName].join('<br/>') : response + '<br/>';

                    let summernoteTextarea = element[0];

                    // remove previous error messages
                    summernoteTextarea.parentNode.querySelector('.invalid-feedback')?.remove();

                    // add the red text classes
                    summernoteTextarea.parentNode.classList.add('text-danger');

                    // create the error message container
                    let errorContainer = document.createElement("div");
                    errorContainer.classList.add('invalid-feedback', 'd-block');
                    errorContainer.innerHTML = errorMessages;
                    summernoteTextarea.parentNode.appendChild(errorContainer);
                }
            };

            xhr.onerror = function() {
                console.error('An error occurred during the upload process');
            };

            xhr.send(data);
        }
        
    }

    element.on('CrudField:disable', function(e) {
        element.summernote('disable');
        element.next('.note-editor').addClass('bp-disabled');
    });

    element.on('CrudField:enable', function(e) {
        element.summernote('enable');
        element.next('.note-editor').removeClass('bp-disabled');
    });

    summernoteOptions['callbacks'] = summernotCallbacks;

    element.summernote(summernoteOptions);

    if (element.attr('disabled')) {
        element.summernote('disable');
        element.next('.note-editor').addClass('bp-disabled');
    }
}

    