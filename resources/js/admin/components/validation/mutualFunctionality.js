export function errorHandler (error, messageHandler, defaultText, vm, errorObj) {
    let errors = error.response.data.error || error.response.data.errors;
    if (Array.isArray(errors)) {
        loopThroughErrors(errors, messageHandler, vm, errorObj);
    } else if (isString(errors)) {
        let error = parseErrors(errors);
        if (Array.isArray(error)) {
            loopThroughErrors(error, messageHandler, vm, errorObj);
        } else {
            let errorString = (error && error.hasOwnProperty('serverError'))
                ? `Помилка сервера: ${error[Object.keys(error)[0]]}`
                : isString(error) ? error : defaultText;
            messageHandler(errorString, 'error');
            vm.set(errorObj, Object.keys(error)[0], error[Object.keys(error)[0]][0]);
        }
    } else {
        if (!error.response.data instanceof Blob) {
            vm.set(errorObj, Object.keys(errors), errors[Object.keys(errors)]);
        } else if(!errors[Object.keys(errors)]) {
            for(let error in errors) {
                messageHandler(errors ? `[${error}] ${errors[error][0]}` : defaultText, 'error');
            }
        } else {
            messageHandler(errors ? errors[Object.keys(errors)] : defaultText, 'error');
        }
    }
};

function isString(str) {
    return typeof str === 'string';
}

function parseErrors(errors) {
    try {
        const error = JSON.parse(errors);
        if ('error' in error) {
            try {
                return JSON.parse(error.error);
            } catch (e) {
                if ('error' in error) { return error.error }
                return error;
            }
        }
    }catch (e) {
        return errors;
    }
}

const maxDate = '9999-12-31';

export function setDateType(dateInputs, fields, isWidth = true) {
    if (dateInputs.length) {
        for(let inputElement of dateInputs) {
            let placeholder = inputElement.getAttribute('placeholder');
            let dateFilter = fields.filter(item => item === placeholder);
            if (dateFilter.length) {
                inputElement.setAttribute('type', 'date');
                inputElement.setAttribute('max', maxDate);
                if (isWidth) {
                    inputElement.setAttribute('style', 'width: 80px');
                    // inputElement.setAttribute('style', 'min-width: 130px');
                }
            }
        }
    }
}

function loopThroughErrors(errors, messageHandler, vm, errorObj) {
    errors.map(error => {
        if (Array.isArray(error)) {
            error = error[0];
        }
        for (let prop in error) {
            messageHandler(`${prop}: ${error[prop]}`, 'error');
            vm.set(errorObj, prop, error[prop]);
        }
    });
}

export function closeModalHandler () {
    $('#cabinet_modal .close').click();
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
}

// for notifications
export function setFieldDeleteDate(category) {
    switch(category) {
        case 'inbox':
        case 'system':
            return 'receiver_delete_date';
        case 'sent':
            return 'sender_delete_date';
        case 'trash':
            return 'all';
    }
}
export const USER_AVA_URL = '/storage/images/avatars/';

export function userAvatartUrl(userImg) {
    const isDefault = userImg.indexOf('noname') > -1 ? true : false;
    return isDefault ? '/images/defaultAva/noname.svg' : `${USER_AVA_URL}${userImg}`;
}
