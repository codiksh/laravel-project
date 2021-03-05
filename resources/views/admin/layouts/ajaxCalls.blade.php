<script>
    let ajax_alert_div;

    async function ajaxCallRequest(url, type, data = {}, loader = true, loadingMsg = 'Fetching details...', callBackFunction = undefined) {
        let ajax_result;
        await $.ajax({
            url: url,
            type: type,
            data: data,
            beforeSend: function () {
                loader && showWaitMeLoading(loadingMsg, '', $('.content-wrapper'));
            },
            success: function (res) {
                ajax_result = res;
                loader && hideWaitMeLoading('', $('.content-wrapper'));
                if (typeof callBackFunction === 'function') {
                    callBackFunction(res);
                }
            },
            error: function (jqXHR) {
                let errorRes = JSON.parse(jqXHR.responseText);
                ajax_result = {status: jqXHR.status, message: errorRes.message, errorData: errorRes.errors};
                ajax_loadToastMsg(ajax_result);
                loader && hideWaitMeLoading('', $('.content-wrapper'));
            }
        });
        return ajax_result;
    }

    function ajaxCallFormSubmit(formElement, isToast, loadingMsg, data = {}, callBackFunction = undefined) {
        $.ajax({
            url: formElement.attr('action'),
            type: formElement.attr('method'),
            processData: false,
            data: data,
            contentType: false,
            beforeSend: function () {
                showWaitMeLoading(loadingMsg, '', $('.content-wrapper'));
            },
            success: function (res) {
                let ajax_result = {status: 200, message: res.message, data: res.data}
                if(! res.hasOwnProperty('message')) {
                    hideWaitMeLoading('', $('.content-wrapper'));    return;
                }
                if (!isToast) {
                    ajax_loadAlertBox(ajax_result, formElement);
                } else {
                    ajax_loadToastMsg(ajax_result);
                }
                if (typeof callBackFunction === 'function') {
                    callBackFunction(res);
                }
                hideWaitMeLoading('', $('.content-wrapper'));
            },
            error: function (jqXHR) {
                let errorRes = JSON.parse(jqXHR.responseText);
                let ajax_result = {status: jqXHR.status, message: errorRes.message, errorData: errorRes.errors};
                if (!isToast) {
                    ajax_loadAlertBox(ajax_result, formElement);
                } else {
                    ajax_loadToastMsg(ajax_result);
                }
                hideWaitMeLoading('', $('.content-wrapper'));
            }
        });
    }

    function ajaxCallDelete(url, confirmMsg, tableId) {
        if (confirm(confirmMsg)) {
            let result;
            $.ajax({
                url: url,
                type: 'DELETE',
                beforeSend: function () {
                    $('#ajax_alert_div').html('');
                    showWaitMeLoading('Fetching details...', '', $('.content-wrapper'));
                },
                success: function (res) {
                    result = res;
                    hideWaitMeLoading('', $('.content-wrapper'));
                    LaravelDataTables[tableId].ajax.reload(null, false);
                    toastr["success"](result.message);
                },
                error: function (jqXHR) {
                    result = {status: jqXHR.status, message: JSON.parse(jqXHR.responseText).message};
                    hideWaitMeLoading('', $('.content-wrapper'));
                    toastr["error"](result.message);
                }
            });
        }
    }

    function showWaitMeLoading(text, containerId, selector = undefined) {
        if (selector === undefined) {
            selector = $('#' + containerId);
        }
        text = typeof text !== 'undefined' ? text : "Loading. Please wait...";
        selector.waitMe({
            'effect': 'rotateplane',
            'text': text,
        });
    }

    function hideWaitMeLoading(containerId, selector = undefined) {
        if (selector === undefined) {
            selector = $('#' + containerId);
        }
        selector.waitMe('hide');
    }

    function ajax_loadAlertBox(ajax_Response, formElement) {
        if (ajax_alert_div === undefined) {
            ajax_alert_div = $('<div>', {
                id: 'ajax_alert_div',
                class: 'alert',
                role: 'alert'
            });
        } else {
            ajax_alert_div.html('').removeClass('alert-success').removeClass('alert-danger');
        }
        ajax_alert_div.append('<button type="button" class="close rspMsgDismissible" data-dismiss="alert" aria-hidden="true">×</button>');
        ajax_alert_div.addClass(ajax_Response.status === 200 ? 'alert-success' : 'alert-danger');

        if (ajax_Response.status === 422) {
            ajax_alert_div.append('<h4 id="ajax_alert_header">Error!</h4>');
            ajax_alert_div.append($('<span>Some invalid inputs were found, please look for the following list of invalid inputs.</span>'));
            let ul_el = '<ul style="margin: 0 !important;padding-left: 22px;">';
            $.each(ajax_Response.errorData, function (i, e) {
                ul_el += '<li>' + e[0] + '</li>';
            });
            ul_el += '</ul>';
            ajax_alert_div.append($(ul_el));
        } else {
            ajax_alert_div.append('<h4 id="ajax_alert_header">' + (ajax_Response.status === 200 ? 'Congratulations! 🎉' : 'Whoops! something went wrong! 😕') + '</h4>');
            ajax_alert_div.append($('<span>' + ajax_Response.message + '</span>'));
        }
        ajax_alert_div.insertBefore(formElement);
        scrollTopFunction();
    }

    function ajax_loadToastMsg(ajax_Response) {
        if (ajax_Response.status === 422) {
            $.each(ajax_Response.errorData, function (i, e) {
                toastr['error'](e[0]);
            });
        } else
            toastr[ajax_Response.status === 200 ? 'success' : 'error'](ajax_Response.message);
    }

    function scrollTopFunction() {
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
    }

</script>
