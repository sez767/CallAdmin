<template>
	<div class="animated fadeIn d-flex flex-column tab-content cabinet-content__wrapper category_form">
        <div class="row">
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="nameHandler" v-text="'Название*'"></div>
                    <input type="text" maxlength="100" :class="[{ 'error-input': errors.name }, 'cabinet-form-input']" v-model="nameHandler" placeholder="Название*">
                    <div><span class="error-text" v-if="errors.name">{{errors.name}}</span></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="codeHandler" v-text="'Код*'"></div>
                    <input type="number" min="2" max="999" :class="[{ 'error-input': errors.code }, 'cabinet-form-input']" v-model="codeHandler" placeholder="Код*">
                    <div><span class="error-text" v-if="errors.code">{{errors.code}}</span></div>
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
    import {isEmptyToError, checkIsReady, errorMessages} from '@adminpages/validation/Validator';
    import {errorHandler} from '@adminpages/validation/mutualFunctionality';
	import Toasted from 'vue-toasted';
	Vue.use(Toasted);
    import messages from '@adminpages/constants/messages';
	
	export default {
		name: 'role-form',
		props: {
            role_data: {
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
				isUpdate: Boolean(this.role_data),
				someData: {
                    name: '',
                    code: '',
				},
                errorMessages: errorMessages(),
                errors: {},
                isReadyToSend: false,
	        }
	    },
	    computed: {
	    	nameHandler: {
                get: function() {
                    return this.someData.name;
                },
                set: function(val) {
                    if (val.length) {
                    	this.someData.name = val;
                        delete this.errors.name;
                    } else {
                    	this.errors.name = isEmptyToError(val, this.errorMessages.required);
                    }
                }
            },
            codeHandler: {
                get: function() {
                    return this.someData.code;
                },
                set: function(val) {
                    if (val.length) {
                    	this.someData.code = val;
                        delete this.errors.code;
                    } else {
                    	this.errors.code = isEmptyToError(val, this.errorMessages.required);
                    }
                }
            },
        },
        mounted() {
            if (this.role_data) {
                this.someData = this.role_data;
            }
		},
		methods: {
			backOffHandler: function () { window.open(this.index_url, '_self'); },
            submitHandler: function () {
                this.checkIsReadyToSend();
                if (this.isReadyToSend) {
                    const updateUrl = this.role_data ? `/${this.role_data.id}` : '';
                    const url = `/admin/roles${updateUrl}`;
                    const axiosMethod = this.role_data ? 'put' : 'post';
                    axios[axiosMethod](url, {role: this.someData})
                        .then(response => {
                            this.successResponse()
                            if (!this.role_data) {
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
                let fields = ['name', 'code'];
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