if (typeof sendQuickButtonAjaxRequest !== 'function') {
    function sendQuickButtonAjaxRequest(button) {
        const tableId = button.getAttribute('data-table-id') ?? 'crudTable';
        const table = window.crud.tables[tableId];
        const route = button.getAttribute('data-route');
        const method = button.getAttribute('data-method');
        const refreshTable = button.getAttribute('data-refresh-table') == '1';

        const defaultButtonMessage = function(button, type) {
            const buttonTitle = button.getAttribute(`data-${type}-title`);
            const buttonMessage =  button.getAttribute(`data-${type}-message`);
            return `<strong>${buttonTitle}</strong><br/>${buttonMessage}`;
        }

        fetch(route, {
            method: method,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
            },
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status >= 200 && status < 300) {
                if (refreshTable && typeof table !== 'undefined') {
                    table.draw(false);
                }
                new Noty({
                    type: "success",
                    text: body.message || defaultButtonMessage(button, 'success'),
                }).show();
            } else {
                throw new Error(body.message || defaultButtonMessage(button, 'error'));
            }
        })
        .catch(error => {
            new Noty({
                type: "error",
                text: error.message,
            }).show();
        });
    }
}

if (typeof sendQuickBulkButtonAjaxRequest !== 'function') {
    function sendQuickBulkButtonAjaxRequest(button) {
        const tableId = button.getAttribute('data-table-id') ?? 'crudTable';
        const tableConfig = window.crud.tableConfigs[tableId] || window.crud;
        const table = window.crud.tables[tableId];
        const checkedItems = tableConfig.checkedItems;

        if (typeof checkedItems === 'undefined' || checkedItems.length === 0) {
            const noEntriesTitle = button.getAttribute('data-bulk-no-entries-title');
            const noEntriesMessage = button.getAttribute('data-bulk-no-entries-message');

            new Noty({
                type: "warning",
                text: `<strong>${noEntriesTitle}</strong><br/>${noEntriesMessage}`
            }).show();

            return;
        }

        const route = button.getAttribute('data-route');
        const method = button.getAttribute('data-method');
        const confirmTitle = button.getAttribute('data-bulk-confirm-title');
        const confirmMessage = button.getAttribute('data-bulk-confirm-message').replace(':number', checkedItems.length);
        const refreshTable = button.getAttribute('data-refresh-table') == '1';

        const defaultButtonMessage = function(button, type) {
            const buttonTitle = button.getAttribute(`data-${type}-title`);
            const buttonMessage = button.getAttribute(`data-${type}-message`);
            return `<strong>${buttonTitle}</strong><br/>${buttonMessage}`;
        }

        swal({
            title: confirmTitle,
            text: confirmMessage,
            icon: "warning",
            buttons: {
                cancel: {
                    text: button.getAttribute('data-confirm-no'),
                    value: null,
                    visible: true,
                    className: "bg-secondary",
                    closeModal: true,
                },
                confirm: {
                    text: button.getAttribute('data-confirm-yes'),
                    value: true,
                    visible: true,
                    className: "bg-primary",
                }
            },
        }).then((value) => {
            if (value) {
                fetch(route, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({ entries: checkedItems })
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(({ status, body }) => {
                    if (status >= 200 && status < 300) {
                        if (refreshTable && typeof table !== 'undefined') {
                            if (table.rows().count() === checkedItems.length) {
                                table.page("previous");
                            }
                            tableConfig.checkedItems = [];
                            table.draw(false);
                        }
                        new Noty({
                            type: "success",
                            text: body.message || defaultButtonMessage(button, 'success'),
                        }).show();
                    } else {
                        throw new Error(body.message || defaultButtonMessage(button, 'error'));
                    }
                })
                .catch(error => {
                    new Noty({
                        type: "error",
                        text: error.message,
                    }).show();
                });
            }
        });
    }
}

    