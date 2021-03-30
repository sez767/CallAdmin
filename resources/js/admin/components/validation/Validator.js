export function isText (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[A-ZА-ЕЖ-ЩЬЮЯЪЁЫЭІЄЇҐа-еж-щьюяъёыэієїґa-z\'\-\s]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isRuText (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[А-ЕЖ-ЩЬЮЯЪЁЫЭа-еж-щьюяъёыэ;\'\-\s]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isUAText (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[А-ЕЖ-ЩЬЮЯІЄЇҐа-еж-щьюяієїґ;\'\-\s]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isUATextWithDigits (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[А-ЕЖ-ЩЬЮЯІЄЇҐа-еж-щьюяієїґ0-9;,\.\'\-\s]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isENTextWithDigits (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[a-zA-Z0-9_;,\`\.\-\s]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isEmail (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^([А-ЕЖ-ЩЬЮЯІЄЇҐа-еж-щьюяієїґA-Za-z0-9,_\.\-]+)(?:[@]{1})?(?:[A-Za-z0-9_\-]+)?(?:[\.]{1})?(?:[A-Za-z]{2,8})?(?:[\.]{1})?(?:[A-Za-z]{2,8})?$/i;
		let matched = val.match(pattern);
		return matched === null ? local.email : false;
	}
	return isEmptyToError(val, local.required);
}

export function isEmptyToError (val, required) {
	if (isObject(val)) {
		return Object.keys(val).length ? false : required;
	} else {
		return (val && val.length !== 0 ) ? false : required;
	}
}

export function isEmpty (val) {
	return (val === undefined || (!val && val.length === 0)) ? true : false;
}

export function isEmptyErrorReturn (val, required) {
	return (!val && val.length === 0 ) ? required : false;
}

export function isSamePass (val, str, local) {
	if (!isEmptyToError(str, local.required)) {
		if (!isEmptyToError(val, local.required) && !isEmptyToError(str, local.required)) {
			let regExp = new RegExp('^'+str+'$', 'g');
			let matched = val.match(regExp);
			return matched === null ? local.confirmRequired : false;
		}
		return isEmptyToError(val, local.required);
	}
	return 'Спершу заповніть поле `Пароль`';
}

export function isPass (val, str, local) {
	if (!isEmptyToError(val, local.required)) {
		if (!isEmptyToError(str, local.required)) {
			let regExp = new RegExp('^'+str+'$', 'g');
			let matched = val.match(regExp);
			return matched === null ? local.confirmRequired : false;
		}
		return false;
	}
	return isEmptyToError(val, local.required);
}

export function isTextWithDigits (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[А-ЕЖ-ЩЬЮЯІЄЇҐЫЭЁЪа-еж-щьюяієїґыэёъa-zA-Z0-9,\.!;:`"\'\-\s]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isEngUkrText (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[А-ЕЖ-ЩЬЮЯІЄЇҐа-еж-щьюяієїґa-zA-Z,\.!;:`"\'\-\s]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isUrl (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^(http)(?:s)?(\:\/\/)([А-ЕЖ-ЩЬЮЯІЄЇҐа-еж-щьюяієїґa-zA-Z0-9=&?_,\.\'\-\s/:]+)?(?:[\.]{1})?(?:[A-Za-z]{2,3})?$/i;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isEngText (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[a-zA-Z,\.\'\-\s]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isGit (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^([A-Za-z0-9,@/:;\_\-\./]*)(?:\.git)$/i;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isPhoneLength (val, local) {
	if (!isEmptyToError(val, local.required)) {
		return val.length < 14 ? local.maxlength : false;
	}
	return false;
}

export function isStarChosen (val, local) {
	return val > 0 ? false : local.required;
}

export function isPerfectStringLength (val, local) {
	if(val.length < 20) {
		return local.minlength;
	} else if(val.length > 500) {
		return local.maxlength;
	}
	return false;
}

export function isPassportIDBlur (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^([А-ЕЖ-ЩЬЮЯІЄЇҐ]{1,2})(?:[\d]{6})$|^([\d]{9})$/i;
		let matched = val.match(pattern);
		return matched === null ? local.wrongData : false;
	}
	return false;
}

export function isPassportIDInput (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^([А-ЕЖ-ЩЬЮЯІЄЇҐ]{1,2})([\d]{1,6})?$|^([\d]{1,9})$/i;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isIPNBlur (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^([\d]{10})$/i;
		let matched = val.match(pattern);
		return matched === null ? local.wrongData : false;
	}
	return false;
}

export function isIPNInput (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^([\d]{1,10})$/i;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isRUTextWithDigitsAndTags (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[a-zA-Z0-9_\.А-ЕЖ-ЩЬЮЯЪЁЫЭа-еж-щьюяъёыэ_%\'\-\s<>!]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isUATextWithDigitsAndTags (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[А-ЕЖ-ЩЬЮЯІЄЇҐа-еж-щьюяієїґa-zA-Z0-9_,%\.\'\-\s<>!]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isENTextWithDigitsAndTags (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[a-zA-Z0-9_,%\.\'\-\s<>!]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function isMaxLength (val, local, maxLength) {
	if (!isEmptyToError(val, local.required)) {
		return val > maxLength ? local.maxlength : false;
	}
	return false;
}

// Returns if a value is an object
function isObject (value) {
	return value && typeof value === 'object' && value.constructor === Object;
}

export function isDigitBetweenAmount (val, local, from, till) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[0-9]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : (matched[0].length !== from && matched[0].length !== till) ? local.maxlength : false;
	}
	return false;
}

export function isFutureDate (val, local, vm) {
	if (!isEmptyToError(val, local.required)) {
		return vm.moment().isAfter(val) ? false : local.date;
	}
	return false;
}

export function isRuTextWithDigits (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[А-ЕЖ-ЩЬЮЯЪЁЫЭа-еж-щьюяъёыэ;0-9,\.\'\-\s]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}

export function errorMessages () {
	return {
        size: 'Размер файла превышает 5 Мб',
        fileType: 'Неверный формат файла',
        pattern: 'Недопустимые символы!',
        required: 'Пожалуйста заполните поле',
        maxlength: 'Значение/количество превышает максимально допустимое',
        server: 'Ошибка сервера',
        fillAll: 'Заполните все поля перед отправкой',
        date: 'введено не корректну дату',
        email: 'Электронная почта не является правильной',
    };
}

export function checkIsReady (that, fields) {
    const requiredFieldsAmount = fields.length;
    const requiredFieldsCounter = checkRequiredFields(that, fields);
    if (requiredFieldsCounter === requiredFieldsAmount) {
        checkErrorsExists(that);
    } else {
        setRequiredFieldsErrors(that, fields);
    }
};

function checkRequiredFields(that, fields) {
	const dataProps = {...that.someData};
    let requiredFieldsCounter = 0;
    for(let prop in dataProps) {
    	const arrIndex = fields.indexOf(prop);
        const isEmptyVal = isEmptyToError(that.someData[prop], that.errorMessages.required);
        if (arrIndex > -1 && !isEmptyVal) {
            requiredFieldsCounter++;
            fields.splice(arrIndex, 1);
        }
    }
    return requiredFieldsCounter;
}

export function checkErrorsExists(that) {
	let ready = [];
    if (that.errors) {
        for(let prop in that.errors) {
            const isErrorExist = (that.errors[prop] !== false && that.errors[prop].length);
            if(isErrorExist) {
                ready.push(true);
            }
        }
    }
    that.isReadyToSend = ready.length ? false : true;
}

function setRequiredFieldsErrors(that, fields) {
	that.isReadyToSend = false;
    fields.map(field => {
        const isEmptyVal = isEmptyToError(that.someData[field], that.errorMessages.required);
        that.$set(that.errors, field, !isEmptyVal ? false : that.errorMessages.required);
    });
    if (that.someData.hasOwnProperty('course_ID')) {
    	that.$store.commit('setCourseErrors', that.errors);
    }
}

export function isAccount (val, local) {
	if (!isEmptyToError(val, local.required)) {
		let pattern = /^[a-zA-Z0-9_\s]+$/;
		let matched = val.match(pattern);
		return matched === null ? local.pattern : false;
	}
	return false;
}
