function bpFieldInitUploadMultipleElement(element) {
	var fieldName = element.attr('data-field-name');
	var clearFileButton = element.find(".file-clear-button");
	var fileInput = element.find("input[type=file]");
	var inputLabel = element.find("label.backstrap-file-label");
				let existingFiles = fileInput.parent().siblings('.existing-file');

				if(fileInput.attr('data-row-number')) {
					let selectedFiles = [];
					existingFiles.find('a.file-clear-button').each(function(item) {
						selectedFiles.push($(this).data('filename'));
					});

					$('<input type="hidden" class="order-uploads" name="_order_'+fieldName+'" value="'+selectedFiles+'">').insertAfter(fileInput);

					var observer = new MutationObserver(function(mutations) {
						mutations.forEach(function(mutation) {
							if(mutation.attributeName == 'data-row-number') {
								let field = $(mutation.target);

								fieldOrder = field.siblings('input[name="'+mutation.target.getAttribute('name').slice(0,-2)+'"]')
								fieldOrder.attr('name', '_order_'+mutation.target.getAttribute('name').slice(0,-2));
								let selectedFiles = [];
								fieldOrder.parent().siblings('.existing-file').find('a.file-clear-button').each(function(item) {
									selectedFiles.push($(this).data('filename'));
								});
								fieldOrder.val(selectedFiles);

								fieldClear = field.siblings('.clear-files');
								fieldClear.attr('name', 'clear_'+mutation.target.getAttribute('name'));
							}
						});
					});

					observer.observe(fileInput[0], {
						attributes: true,
					});
				}

		        clearFileButton.click(function(e) {
		        	e.preventDefault();
		        	var container = $(this).parent().parent();
		        	var parent = $(this).parent();
		        	// remove the filename and button
		        	parent.remove();

					if(fileInput.attr('data-row-number')) {
						let selectedFiles = [];
						fileInput.parent().siblings('.existing-file').find('a.file-clear-button').each(function(item) {
							selectedFiles.push($(this).data('filename'));
						});
						if(selectedFiles.length > 0) {
							fileInput.siblings('.order-uploads').val(selectedFiles);
						} else {
							fileInput.siblings('.order-uploads').remove();
						}
					}
		        	// if the file container is empty, remove it
		        	if ($.trim(container.html())=='') {
		        		container.remove();
		        	}
		        	$("<input type='hidden' class='clear-files' name='clear_"+fieldName+"[]' value='"+$(this).data('filename')+"'>").insertAfter(fileInput);
		        });

		        // accumulate files across multiple picks (browser replaces FileList before change fires)
		        var accumulatedDt = new DataTransfer();

		        fileInput.change(function() {
					let existingFiles = fileInput.parent().siblings('.existing-file');

					// capture newly picked files first (fileInput.files is already replaced by browser)
					let newlyPicked = Array.from($(this)[0].files);

					// add to accumulated DataTransfer, skip duplicates by name
					newlyPicked.forEach(function(file) {
						var alreadyAdded = Array.from(accumulatedDt.files).some(function(f) { return f.name === file.name; });
						if (!alreadyAdded) {
							accumulatedDt.items.add(file);
						}
					});

					// assign the full accumulated list back to the input
					fileInput[0].files = accumulatedDt.files;

					let allFiles = Array.from(accumulatedDt.files).map(function(file) {
						return {name: file.name, type: file.type};
					});

					element.find('input').first().val(JSON.stringify(allFiles)).trigger('change');

					// create badges only for the newly picked files
					let files = '';
					newlyPicked.forEach(file => {
						files += '<span class="badge mt-1 mb-1 text-bg-secondary badge-primary new-file-badge" data-filename="'+file.name+'">'
						       + file.name
						       + ' <a href="#" class="new-file-remove" data-filename="'+file.name+'" style="color:inherit;margin-left:4px;text-decoration:none;">&times;</a>'
						       + '</span> ';
					});

					// if existing files container is not on the page, create it
					if(existingFiles.length === 0) {
						existingFiles = $('<div class="well well-sm existing-file mb-2"></div>');
						existingFiles.insertBefore(element.find('input[type=hidden]').first());
						existingFiles.html(files);
					}else {
						existingFiles.append(files);
					}

		        	// remove the hidden input, so that the setXAttribute method is no longer triggered
					$(this).next("input[type=hidden]:not([name='clear_"+fieldName+"[]']):not([name='_order_"+fieldName+"'])").remove();
		        });
				// handle removal of newly selected (not yet uploaded) files
				element.on('click', '.new-file-remove', function(e) {
					e.preventDefault();
					var filenameToRemove = $(this).data('filename');

					// rebuild both accumulatedDt and FileList without the removed file
					var dt = new DataTransfer();
					Array.from(accumulatedDt.files).forEach(function(file) {
						if (file.name !== filenameToRemove) {
							dt.items.add(file);
						}
					});
					accumulatedDt = dt;
					fileInput[0].files = accumulatedDt.files;

					// remove the badge from the DOM
					$(this).closest('.new-file-badge').remove();

					// remove the existing-file container if now empty
					var existingFilesEl = fileInput.parent().siblings('.existing-file');
					if (existingFilesEl.length && $.trim(existingFilesEl.html()) === '') {
						existingFilesEl.remove();
					}

					// update the hidden input with remaining files
					var remainingFiles = Array.from(fileInput[0].files).map(function(file) {
						return {name: file.name, type: file.type};
					});
					element.find('input').first().val(JSON.stringify(remainingFiles)).trigger('change');
				});
				element.find('input').on('CrudField:disable', function(e) {
					element.children('.backstrap-file').find('input').prop('disabled', 'disabled');
					element.children('.existing-file').find('.file-preview').each(function(i, el) {

						let $deleteButton = $(el).find('a.file-clear-button');

						if($deleteButton.length > 0) {
							$deleteButton.on('click.prevent', function(e) {
								e.stopImmediatePropagation();
								return false;
							});
							// make the event we just registered, the first to be triggered
							$._data($deleteButton.get(0), "events").click.reverse();
						}
					});
				});

				element.on('CrudField:enable', function(e) {
					element.children('.backstrap-file').find('input').removeAttr('disabled');
					element.children('.existing-file').find('.file-preview').each(function(i, el) {
						$(el).find('a.file-clear-button').unbind('click.prevent');
					});
				});
}

        