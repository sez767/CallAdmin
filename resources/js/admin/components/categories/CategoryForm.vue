<template>
	<div class="animated fadeIn d-flex flex-column tab-content cabinet-content__wrapper category_form">
        <div class="row">
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="nameUaHandler" v-text="'Название (ua)*'"></div>
                    <input type="text" maxlength="100" :class="[{ 'error-input': errors.name_ua }, 'cabinet-form-input']" v-model="nameUaHandler" placeholder="Название (ua)*">
                    <div><span class="error-text" v-if="errors.name_ua">{{errors.name_ua}}</span></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="nameRuHandler" v-text="'Название (ru)*'"></div>
                    <input type="text" maxlength="100" :class="[{ 'error-input': errors.name_ru }, 'cabinet-form-input']" v-model="nameRuHandler" placeholder="Название (ru)*">
                    <div><span class="error-text" v-if="errors.name_ru">{{errors.name_ru}}</span></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="nameEnHandler" v-text="'Название (en)*'"></div>
                    <input type="text" maxlength="100" :class="[{ 'error-input': errors.name_en }, 'cabinet-form-input']" v-model="nameEnHandler" placeholder="Название (en)*">
                    <div><span class="error-text" v-if="errors.name_en">{{errors.name_en}}</span></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper pl-2">
                    <div class="absolute-checkbox-label" v-text="'Активність'"></div>
                    <input
                        type="checkbox"
                        name="active"
                        v-model="activeHandler"
                    >
                    <div>
                        <span class="error-text" v-if="errors.active" v-text="errors.active"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button
                type="button"
                v-text="'Сохранить'"
                class="btn btn-success"
                @click="submitHandler"></button>
            <button
                type="button"
                v-text="'Назад'"
                class="btn btn-outline-secondary ml-2"
                @click="backOffHandler"></button>
        </div>
	</div>
</template>

<script>
    import {
            isEmptyToError, isENTextWithDigitsAndTags, checkIsReady, isUATextWithDigitsAndTags,
            isRUTextWithDigitsAndTags, errorMessages
        } from '@adminpages/validation/Validator';
    import {errorHandler} from '@adminpages/validation/mutualFunctionality';
	import Toasted from 'vue-toasted';
	Vue.use(Toasted);
    import messages from '@adminpages/constants/messages';
	
	export default {
		name: 'category-form',
		props: {
            category_data: {
                type: [Object],
                default: () => null
            },
            index_url: {
                type: [String],
                default: () => null
            },
        },
        data() {
	        return {
				isUpdate: Boolean(this.category_data),
				someData: {
                    name_en: '',
                    name_ru: '',
                    name_ua: '',
                    active: true,
				},
                errorMessages: errorMessages(),
                errors: {},
                isReadyToSend: false,
	        }
	    },
	    computed: {
            activeHandler: {
                get: function() {
                    return this.someData.active;
                },
                set: function(val) {
                    this.someData.active = val;
                    delete this.errors.active;
                }
            },
	    	nameUaHandler: {
                get: function() {
                    return this.someData.name_ua;
                },
                set: function(val) {
                    if (val.length) {
                    	this.someData.name_ua = val;
                        delete this.errors.name_ua;
                        this.errors.name_ua = isUATextWithDigitsAndTags(val, this.errorMessages);
                    } else {
                    	this.errors.name_ua = isEmptyToError(val, this.errorMessages.required);
                    }
                }
            },
            nameRuHandler: {
                get: function() {
                    return this.someData.name_ru;
                },
                set: function(val) {
                    if (val.length) {
                    	this.someData.name_ru = val;
                        delete this.errors.name_ru;
                        this.errors.name_ru = isRUTextWithDigitsAndTags(val, this.errorMessages);
                    } else {
                    	this.errors.name_ru = isEmptyToError(val, this.errorMessages.required);
                    }
                }
            },
            nameEnHandler: {
                get: function() {
                    return this.someData.name_en;
                },
                set: function(val) {
                    if (val.length) {
                    	this.someData.name_en = val;
                        delete this.errors.name_en;
                        this.errors.name_en = isENTextWithDigitsAndTags(val, this.errorMessages);
                    } else {
                    	this.errors.name_en = isEmptyToError(val, this.errorMessages.required);
                    }
                }
            },
        },
        mounted() {
            if (this.category_data) {
                this.someData = this.category_data;
            }
		},
		methods: {
			backOffHandler: function () { window.open(this.index_url, '_self'); },
            submitHandler: function () {
                this.checkIsReadyToSend();
                if (this.isReadyToSend) {
                    const updateUrl = this.category_data ? `/${this.category_data.id}` : '';
                    const url = `/admin/categories${updateUrl}`;
                    const axiosMethod = this.category_data ? 'put' : 'post';
                    axios[axiosMethod](url, {category: this.someData})
                        .then(response => {
                            this.successResponse()
                            if (!this.category_data) {
                                this.backOffHandler();
                            }
                        })
                        .catch(error => this.errorParser(error));
                } else {
                    setTimeout(() => {
                        const el = document.getElementsByClassName('error-text')[0];
                        if (el) {
                            el.scrollIntoView({block: "center", behavior: "smooth"})
                        }
                    }, 500);

                    this.messageHandler(messages.error.required, 'info');
                }
            },
            checkIsReadyToSend: function () {
                let fields = ['name_ua', 'name_ru', 'name_en'];
                checkIsReady(this, fields);
            },
            messageHandler: function(message, type) {
                let myToast = this.$toasted.show(messages.error.system, {type: type});
                myToast.text(message).goAway(2000);
            },
            errorParser: function (error) {
                errorHandler(error, this.messageHandler, messages.error.transaction, Vue, this.errors);
                this.$forceUpdate();
            },
            successResponse: function () {
                this.errors = {};
                this.messageHandler(messages.success.saved, 'success');
            },
		}
	}
</script>