<template>
    <div class="animated fadeIn d-flex flex-column tab-content cabinet-content__wrapper product_form">
         <div class="cabinet-content__header">
            <div v-if="isUpdate" class="cabinet-content__title">Редактировать товар</div>
            <div v-else class="cabinet-content__title">Новый товар</div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="nameEngHandler">Название (en)*</div>
                    <input type="text" maxlength="100" :class="[{ 'error-input': errors.name_en }, 'cabinet-form-input']" v-model="nameEngHandler" placeholder="Название (en)*">
                    <div><span class="error-text" v-if="errors.name_en">{{errors.name_en}}</span></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="nameRusHandler">Название (ru)*</div>
                    <input type="text" maxlength="100" :class="[{ 'error-input': errors.name_ru }, 'cabinet-form-input']" v-model="nameRusHandler" placeholder="Название (ru)*">
                    <div><span class="error-text" v-if="errors.name_ru">{{errors.name_ru}}</span></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="nameUaHandler">Название (ua)*</div>
                    <input type="text" maxlength="100" :class="[{ 'error-input': errors.name_ua }, 'cabinet-form-input']" v-model="nameUaHandler" placeholder="Название (ua)*">
                    <div><span class="error-text" v-if="errors.name_ru">{{errors.name_ua}}</span></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="codeHandler">Код*</div>
                    <input type="text" maxlength="100" :class="[{ 'error-input': errors.code }, 'cabinet-form-input']" v-model="codeHandler" placeholder="Код*">
                    <div><span class="error-text" v-if="errors.code">{{errors.code}}</span></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="someData.description_en">Описание (en)</div>
                    <textarea rows="5" :class="[{ 'error-input': errors.description_en }, 'cabinet-form-input']" v-model="someData.description_en" placeholder="Описание (en)"></textarea>
                    <div><span class="error-text" v-if="errors.description_en">{{errors.description_en}}</span></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="someData.description_ru">Описание (ru)</div>
                    <textarea rows="5" :class="[{ 'error-input': errors.description_ru }, 'cabinet-form-input']" v-model="someData.description_ru" placeholder="Описание (ru)"></textarea>
                    <div><span class="error-text" v-if="errors.description_ru">{{errors.description_ru}}</span></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="someData.description_ua">Описание (ua)</div>
                    <textarea rows="5" :class="[{ 'error-input': errors.description_ua }, 'cabinet-form-input']" v-model="someData.description_ua" placeholder="Описание (ua)"></textarea>
                    <div><span class="error-text" v-if="errors.description_ua">{{errors.description_ua}}</span></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="manufacturerHandler">Изготовитель*</div>
                    <input type="text" maxlength="100" :class="[{ 'error-input': errors.manufacturer }, 'cabinet-form-input']" v-model="manufacturerHandler" placeholder="Изготовитель*">
                    <div><span class="error-text" v-if="errors.manufacturer">{{errors.manufacturer}}</span></div>
                </div>
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="someData.country">Страна</div>
                    <input type="text" maxlength="100" :class="[{ 'error-input': errors.country }, 'cabinet-form-input']" v-model="someData.country" placeholder="Страна">
                    <div><span class="error-text" v-if="errors.country">{{errors.country}}</span></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="priceHandler">Цена*</div>
                    <input type="number" min="0" :class="[{ 'error-input': errors.price }, 'cabinet-form-input']" v-model="priceHandler" placeholder="Цена*">
                    <div><br><span class="error-text" v-if="errors.price">{{errors.price}}</span></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cabinet-form-input__wrapper">
                    <div class="absolute-input-label" v-if="amountHandler">Количество*</div>
                    <input type="number" min="0" :class="[{ 'error-input': errors.amount }, 'cabinet-form-input']" v-model="amountHandler" placeholder="Количество*">
                    <div><br><span class="error-text" v-if="errors.amount">{{errors.amount}}</span></div>
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <multiselect 
                        class="cabinet-form-input__wrapper"
                        :class="{ 'error-input': errors.categories }"
                        v-model="someData.categories" 
                        :options="allCategories"
                        :multiple="true"
                        :placeholder = '`Категории*`'
                        :hide-selected="true"
                        :show-no-results="true"
                        :selectLabel="'Выбрать'"
                        :deselectLabel="'Убрать'"
                        :clear-on-select="false"
                        :close-on-select="false"
                        label="name_ru"
                        track-by="name_ru"
                        @input="deleteErr"
                    >
                        <span slot="noResult" v-html="'Нет результатов'" />
                    </multiselect>
                    <div><span class="error-text" v-if="errors.categories">{{errors.categories}}</span></div> 
                </div>
            </div>
        </div>
        <crop-gram
            ref="cropgram"
            canvas-color="#F7F7F7"
            placeholder-color="#67ACFD"
            selection-text-class="px-2 mb-1 text-left small-9 text-uppercase text-primary2 spacing-05"
            force-cache-break
            selection-text="Выбрать еще фото"
            placeholder="Выбрать фото"
            :itemsLimit="imgCount"
            :placeholder-font-size="18"
            :file-size-limit="20000 * 1024"
            :key="componentKey"
            >
        </crop-gram>
        <div v-if="isUpdate" class="row">
            <div v-for="image in someData.images" :key="image.id" class="box-img">
                <img :src="'/storage/productImages/'+image.image" alt="img" style="max-height: 150px; max-width: 150px; margin: 10px 10px 0 0; ">
                <div class="close-container" @click="deleteImgHandler(image.id)" >
                    <div class="leftright"></div>
                    <div class="rightleft"></div>
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
    		isEmptyToError, isENTextWithDigits, isEngText, checkIsReady, isUATextWithDigitsAndTags,
    		isMaxLength, isRUTextWithDigitsAndTags, errorMessages
    	} from '@adminpages/validation/Validator';
    import {errorHandler} from '@adminpages/validation/mutualFunctionality';
    import Toasted from 'vue-toasted';
    import CropGram from 'vue-cropgram';
    import Multiselect from 'vue-multiselect';
    import FormMultySelect from "../form_templates/FormMultySelect";
    Vue.use(Toasted);
	export default {
	    name: 'products-form',
        props: ['edit', 'prodid'],
        components: {
            CropGram,
            Multiselect,
            FormMultySelect,
        },
	    data() {
	        return {
				isUpdate: this.edit,
                imgCount: 8,
                pictures: [],
                allCategories: [],
                componentKey: 0,
				someData: {
                    name_en: '',
                    name_ua: '',
                    name_ru: '',
                    code: '',
                    description_en: '',
                    description_ua: '',
                    description_ru: '',
                    manufacturer: '',
                    amount: '',
                    price: '',
                    country: '',
                    categories: [],
                    images: [],
				},
                errorMessages: errorMessages(),
                errors: {},
                isReadyToSend: false,
                urlGet: '/products',
	        }
	    },
		methods: {
	        fetchData() {
                axios.get(`/admin/product/data/${this.prodid}`)
                    .then(resp => {
                        if(resp.data){
                            this.someData = resp.data;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getCategories(){
                axios.get(`/admin/categories/data`)
                    .then(resp => {
                        if(resp.data){
                            this.allCategories = resp.data.rows;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            backOffHandler() { window.location.href = '/admin/products' },
            getFormData(object) {
                const formData = new FormData();
                Object.keys(object).forEach(key => formData.append(key, object[key]));
                return formData;
            },
            async submitHandler() {
                this.checkIsReadyToSend();
				if (this.isReadyToSend) {
                    const data =  this.getFormData(this.someData);
                    const result = await this.$refs.cropgram.save();
                    result.forEach((picture, index) => {
                        data.append(`newPictures[${index}]`,picture.blob);
                    });
                    this.someData.categories.forEach((cat, index) => {
                        data.append(`categoryId[${index}]`,cat.id);
                    });
                    const extraUrl = this.someData.id ? `/${this.someData.id}/update` : '';
                    const url = `/admin${this.urlGet}`;
                         axios.post(`${url}${extraUrl}`, data)
                        .then(response => {
                            this.successResponse();
                            this.backOffHandler();
                        })
                        .catch(error => this.errorParser(error));   
                } else {
                    this.messageHandler('Заполните все поля перед отправкой', 'info');
                }
            },
            deleteImgHandler(imgId){
                axios.post(`/admin${this.urlGet}/${this.someData.id}/deleteImg`, {imageId: imgId})
                        .then(response => {
                            this.successResponse();
                            this.someData.images = response.data;
                        })
                        .catch(error => this.errorParser(error));       
            },
            checkIsReadyToSend: function () {
                let fields = ['name_en', 'name_ru', 'name_ua', 'categories', 'code', 'manufacturer', 'price', 'amount'];
                checkIsReady(this, fields);
            },
            deleteErr () {delete this.errors.categories},
            messageHandler: function(message, type) {
                let myToast = this.$toasted.show('Системная ошибка', {type: type});
                myToast.text(message).goAway(2000);
            },
            errorParser: function (error) {
                errorHandler(error, this.messageHandler, 'Ошибка транзакции', Vue, this.errors);
                this.$forceUpdate();
            },
            successResponse: function () {
                this.errors = {};
                this.messageHandler('Сохранено', 'success');
            },
            messageHandler: function(message, type) {
                let myToast = this.$toasted.show('Системная ошибка', {type: type});
                myToast.text(message).goAway(2000);
            },
		},
        computed: {
	    	nameEngHandler: {
                get: function() {
                    return this.someData.name_en;
                },
                set: function(val) {
                    if (val.length) {
                    	this.someData.name_en = val;
                        delete this.errors.name_en;
                    } else {
                    	this.errors.name_en = isEmptyToError(val, this.errorMessages.required);
                    }
                }
            },
            nameRusHandler: {
                get: function() {
                    return this.someData.name_ru;
                },
                set: function(val) {
                    if (val.length) {
                    	this.someData.name_ru = val;
                        delete this.errors.name_ru;
                    } else {
                    	this.errors.name_ru = isEmptyToError(val, this.errorMessages.required);
                    }
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
                    } else {
                    	this.errors.name_ua = isEmptyToError(val, this.errorMessages.required);
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
            amountHandler: {
                get: function() {
                    return this.someData.amount;
                },
                set: function(val) {
                    if (val.length) {
                    	this.someData.amount = val;
                        delete this.errors.amount;
                    } else {
                    	this.errors.amount = isEmptyToError(val, this.errorMessages.required);
                    }
                }
            },
            priceHandler: {
                get: function() {
                    return this.someData.price;
                },
                set: function(val) {
                    if (val.length) {
                    	this.someData.price = val;
                        delete this.errors.price;
                    } else {
                    	this.errors.price = isEmptyToError(val, this.errorMessages.required);
                    }
                }
            },
            manufacturerHandler: {
                get: function() {
                    return this.someData.manufacturer;
                },
                set: function(val) {
                    if (val.length) {
                    	this.someData.manufacturer = val;
                        delete this.errors.manufacturer;
                    } else {
                    	this.errors.manufacturer = isEmptyToError(val, this.errorMessages.required);
                    }
                }
            },
		},
		mounted() {
            if (this.isUpdate) {
                this.fetchData();
            }
            this.getCategories();
		},
	}
</script>

