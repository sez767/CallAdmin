<template>
  <div>
    <title-bar :title-stack="titleStack"/>
    <hero-bar>
      {{ heroTitle }}
      <router-link slot="right" to="/sites/index" class="button">
        Назад
      </router-link>
    </hero-bar>
    <section class="section is-main-section">
      
        <b-tabs v-model="activeTab">
        <b-tab-item label="Настроить сайт">
        <card-component title="" icon="focus-field-horizontal" class="tile is-child">
          <b-field label="Включить">
              <b-switch 
                v-model="form.is_active"
                true-value="1"
                false-value="0"
                >
              </b-switch>
          </b-field>
          <hr>
          <b-field v-if="form.is_active==1" label="Онлайн чат">
              <b-switch 
                v-model="form.is_chat"
                true-value="1"
                false-value="0"
              >
              </b-switch>
          </b-field>
           <b-field v-else label="Онлайн чат">
              <b-switch 
                disabled
                v-model="form.is_chat"
                true-value="1"
                false-value="0"
              ></b-switch>
          </b-field>
          <div v-if="form.is_chat==1 && form.is_active==1">
              <b-field v-if="form.is_chat==1" label="Автоприветствие">
                <b-switch 
                  v-model="form.is_answer"
                  true-value="1"
                  false-value="0"
                ></b-switch>
              </b-field>
              
              <b-field v-else label="Автоприветствие">
                <b-switch
                  disabled
                  v-model="form.is_answer"
                  true-value="1"
                  false-value="0"
                ></b-switch>
              </b-field> 

              <div v-if="form.is_answer==1">
                <b-field label="Время автоприветствия">
                  <b-numberinput class="inputWidth" v-model="form.answer_sec" placeholder="15" :min="15"></b-numberinput>
                </b-field>
                <b-field label="Текст автоприветствия" message="">
                  <b-input class="inputWidth" placeholder="Текст" v-model="form.answer_text"/>
                </b-field>
              </div>
              
        </div>
        <hr>
        <b-field>
          <b-button type="is-primary" :loading="isLoading" @click.prevent="submit">Сохранить</b-button>
        </b-field>
        </card-component>
        </b-tab-item>
        <b-tab-item label="Код для установки на сайт">
        <card-component title="" icon="calendar-text" class="tile is-child">
          <b-field label="Разместите код на всех страницах вашего сайта перед тегом /head или отправьте его веб-мастеру">
            <b-input 
              ref="widgetText"
              maxlength="200" 
              type="textarea" 
              readonly
              :value="widgetCode"
              ></b-input>
        </b-field> 
        <b-button type="is-success" :loading="isLoading" @click.prevent="copyClipboard">Копировать</b-button>
        </card-component> 
        </b-tab-item>
       
      <b-tab-item label="Настройка виджета">
        <card-component title="" icon="calendar-text" class="tile is-child">
            <b-field label="Размер виджета" >
            <b-slider style="padding-left: 20px;" v-model="form.widget_size" lazy class="inputWidth" size="is-medium" :min="1" :max="3" aria-label="wSize" :tooltip="false">
                <b-slider-tick :value="1">Маленький</b-slider-tick>
                <b-slider-tick :value="2">Средний</b-slider-tick>
                <b-slider-tick :value="3">Большой</b-slider-tick>
            </b-slider>
        </b-field>
        <hr>
        <b-field label="Цвет виджета">
          <v-input-colorpicker  v-model="form.widget_color" />  
        </b-field>
        <hr>
        <b-field>
          <b-button type="is-primary" :loading="isLoading" @click.prevent="submit">Сохранить</b-button>
        </b-field>
        </card-component>
      </b-tab-item>
     </b-tabs>  
    </section>
  </div>
</template>

<script>
import clone from 'lodash/clone'
import TitleBar from '@/components/TitleBar'
import HeroBar from '@/components/HeroBar'
import Tiles from '@/components/Tiles'
import CardComponent from '@/components/CardComponent'
import FilePicker from '@/components/FilePicker'
import UserAvatar from '@/components/UserAvatar'
import Notification from '@/components/Notification'
import InputColorPicker from "vue-native-color-picker";

export default {
  name: 'SitesForm',
  components: { 
    UserAvatar,
    FilePicker, 
    CardComponent, 
    Tiles, 
    HeroBar, 
    TitleBar,
    Notification,
    "v-input-colorpicker": InputColorPicker,
  },
  props: {
    id: {
      default: null
    }
  },
  data () {
    return {
      isLoading: false,
      activeTab: 0,
      item: null,
      form: this.getClearFormObject(),
      createdReadable: null,
      widgetCode: '<!-- CallAdmin Widget --><script id="CA" type="module" async src="https:///widget.js?client=333"><\/script><!-- /CallAdmin Widget -->',
    }
  },
  computed: {
    titleStack () {
      let lastCrumb

      if (this.isProfileExists) {
        lastCrumb = this.form.name
      } else {
        lastCrumb = 'Новый сайт'
      }

      return [
        'CallAdmin',
        'Сайты',
        lastCrumb
      ]
    },
    heroTitle () {
        return this.form.name
    },
    formCardTitle () {
        return 'Настроить сайт'
    },
    isProfileExists () {
      return !!this.item
    }
  },
  created () {
    this.getData()
  },
  methods: {
    getClearFormObject () {
      return {
        id: null,
        is_active: 0,
        is_chat: 0,
        is_answer: 0,
        answer_sec: null,
        answer_text: '',
        widget_size: 0,
        widget_color: '',
      }
    },
    getData () {
      if (this.id) {
        axios
          .get(`/sites/${this.id}`)
          .then(r => {
            this.form = r.data.data
            this.item = clone(r.data.data)
          })
          .catch(e => {
            this.item = null

            this.$buefy.toast.open({
              message: `Error: ${e.message}`,
              type: 'is-danger',
              queue: false
            })
          })
      }
    },
    copyClipboard() {
          navigator.clipboard.writeText(this.widgetCode);
          this.$buefy.snackbar.open({
            message: 'Скопировано',
            queue: false
          })
    },
    submit () {
      this.isLoading = true
      let method = 'patch'
      let url = `/sites/${this.id}`
      
      axios({
        method,
        url,
        data: this.form
      }).then(r => {
        this.isLoading = false
        this.$router.go(-1);
          this.item = r.data.data

          this.$buefy.snackbar.open({
            message: 'Сохранено',
            queue: false
          })
        
      }).catch(e => {
        this.isLoading = false

        this.$buefy.toast.open({
          message: `Error: ${e.message}`,
          type: 'is-danger',
          queue: false
        })
      })
    }
  },
  watch: {
    id (newValue) {
      this.form = this.getClearFormObject()
      this.item = null

      if (newValue) {
        this.getData()
      }
    }
  }
}
</script>

<style>
  .inputWidth{
    max-width: 50%
  }
@media screen and (max-width: 700px) {
  .inputWidth{
    max-width: 100%
  }
}
</style>
