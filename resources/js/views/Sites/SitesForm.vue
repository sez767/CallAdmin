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
      <tiles>
        <card-component :title="formCardTitle" icon="account-edit" class="tile is-child">
          <form @submit.prevent="submit">
            <template v-if="id">
              <b-field label="ID" horizontal>
                <b-input :value="id" custom-class="is-static" readonly />
              </b-field>
            </template>
            <user-avatar v-if="isProfileExists" :avatar="item.avatar" :is-current-user="false" class="image has-max-width is-aligned-center"/>
            <hr>
            <b-field label="Лого" horizontal>
              <file-picker @file-id-updated="fileIdUpdated" :current-file="form.avatar_filename"/>
            </b-field>
            <hr>
            <b-field label="Название" message="" horizontal>
              <b-input placeholder="Название сайта" v-model="form.name" required />
            </b-field>
            <b-field label="Url сайта" message="" horizontal>
              <b-input placeholder="Url сайта" v-model="form.url" required />
            </b-field>
            <hr>
            <b-field horizontal>
              <b-button type="is-primary" :loading="isLoading" native-type="submit">Сохранить</b-button>
            </b-field>
          </form>
        </card-component>
        <card-component v-if="isProfileExists" title="Настроить сайт" icon="account" class="tile is-child">
          <b-field label="Включить" horizontal>
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
                  <b-numberinput v-model="form.answer_sec" placeholder="15" :min="15"></b-numberinput>
                </b-field>
                <b-field label="Текст автоприветствия" message="">
                  <b-input placeholder="Текст" v-model="form.answer_text"/>
                </b-field>
              </div>
              
        </div>

        </card-component>
      </tiles>
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

export default {
  name: 'SitesForm',
  components: { UserAvatar, FilePicker, CardComponent, Tiles, HeroBar, TitleBar, Notification },
  props: {
    id: {
      default: null
    }
  },
  data () {
    return {
      isLoading: false,
      item: null,
      form: this.getClearFormObject(),
      createdReadable: null,
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
      if (this.isProfileExists) {
        return this.form.name
      } else {
        return 'Новый сайт'
      }
    },
    formCardTitle () {
      if (this.isProfileExists) {
        return 'Редактировать сайт'
      } else {
        return 'Новый сайт'
      }
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
        name: null,
        url: null,
        avatar: null,
        avatar_filename: null,
        file_id: 0,
        is_active: 0,
        is_chat: 0,
        is_answer: 0,
        answer_sec: null,
        answer_text: '',
      }
    },
    getData () {
      if (this.id) {
        axios
          .get(`/sites/${this.id}`)
          .then(r => {
            this.form = r.data.data
            this.item = clone(r.data.data)
            this.showAnswer = r.data.data.is_chat
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
    fileIdUpdated (fileId) {
      this.form.file_id = fileId
      this.form.avatar_filename = null
    },
    input (v) {
      //this.createdReadable = moment(v).format('MMM D, Y').toString()
    },
    submit () {
      this.isLoading = true
      let method = 'post'
      let url = '/sites/store'

      if (this.id) {
        method = 'patch'
        url = `/sites/${this.id}`
      }

      axios({
        method,
        url,
        data: this.form
      }).then(r => {
        this.isLoading = false
        this.$router.go(-1);
        if (!this.id && r.data.data.id) {
          this.$buefy.snackbar.open({
            message: 'Создан',
            queue: false
          })
        } else {
          this.item = r.data.data

          this.$buefy.snackbar.open({
            message: 'Сохранен',
            queue: false
          })
        }
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
