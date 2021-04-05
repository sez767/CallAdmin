<template>
  <div>
    <title-bar :title-stack="['CallAdmin', 'Персонал']"/>
    <hero-bar>
      Персонал
      <b-button label="Пригласить" style="font-size: 16px;" size="is-medium" slot="right"
        @click="modalHandler = true"
         />
    </hero-bar>
    <section class="section is-main-section">
      <card-component class="has-table has-mobile-sort-spaced" icon="account-multiple">
        <b-table
          :checked-rows.sync="checkedRows"
          :checkable="false"
          :loading="isLoading"
          :paginated="paginated"
          :per-page="perPage"
          :striped="true"
          :hoverable="true"
          default-sort="name"
          :data="clients">
            <b-table-column label="ID" field="id" sortable v-slot="props">
              {{ props.row.id }}
            </b-table-column>
            <b-table-column label="Аватар" class="has-no-head-mobile is-image-cell" v-slot="props">
              <div v-if="props.row.avatar" class="image">
                <img :src="props.row.avatar" class="is-rounded">
              </div>
            </b-table-column>
            <b-table-column label="Имя" field="name" sortable v-slot="props">
              {{ props.row.name }}
            </b-table-column>
            <b-table-column label="Email" field="email" sortable v-slot="props">
              {{ props.row.email }}
            </b-table-column>
            <b-table-column label="Сайты" field="city" sortable v-slot="props">
              <div v-for="site in props.row.sites" v-bind:key="site.id">
                {{ site.url }}
              </div>
            </b-table-column>
            
            <b-table-column custom-key="actions" class="is-actions-cell" v-slot="props">
              <div class="buttons is-right">
                <router-link disabled :to="{name:'staff.edit', params: {id: props.row.id}}" class="button is-small is-primary">
                  <b-icon icon="account-edit" size="is-small"/>
                </router-link>
                <button disabled class="button is-small is-danger" type="button" @click.prevent="trashModal(props.row)">
                  <b-icon icon="trash-can" size="is-small"/>
                </button>
              </div>
            </b-table-column>
        <b-modal v-model="modalHandler">
                <div class="modal-card" style="width: auto;">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Пригласить</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalHandler = !modalHandler"/>
                    </header>
                    <section class="modal-card-body">
                        <b-field label="Выберите сайт">
                          <b-select placeholder="Выберите ваш сайт" v-model="modal.site" expanded>
                              <option
                                v-for="option in sites"
                                :value="option.id"
                                :key="option.id"
                                >
                                {{ option.url }}
                              </option>
                          </b-select>
                        </b-field>
                        <b-field label="Email">
                            <b-input
                                type="email"
                                icon="email"
                                placeholder="Почта"
                                v-model="modal.email"
                                required>
                            </b-input>
                        </b-field>
                   </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Отправить"
                            type="is-primary"
                            @click="submitModal"
                             />
                    </footer>
                </div>
        </b-modal>
          <section class="section" slot="empty">
            <div class="content has-text-grey has-text-centered">
              <template v-if="isLoading">
                <p>
                  <b-icon icon="dots-horizontal" size="is-large"/>
                </p>
                <p>Загружаем...</p>
              </template>
              <template v-else>
                <p>
                  <b-icon icon="emoticon-sad" size="is-large"/>
                </p>
                <p>Ничего нет, добавьте новый сайт&hellip;</p>
              </template>
            </div>
          </section>
        </b-table>
      </card-component>
    </section>
  </div>

</template>

<script>
import map from 'lodash/map'
import CardComponent from '@/components/CardComponent'
import ModalBox from '@/components/ModalBox'
import TitleBar from '@/components/TitleBar'
import HeroBar from '@/components/HeroBar'
import CardToolbar from '@/components/CardToolbar'

export default {
  name: "ClientIndex",
  components: {CardToolbar, HeroBar, TitleBar, ModalBox, CardComponent},
  data () {
    return {
      isModalActive: false,
      modalHandler: false,
      trashObject: null,
      clients: [],
      isLoading: false,
      paginated: false,
      perPage: 10,
      checkedRows: [],
      isReadyToSend: false,
      modal: {
        site: null,
        email: null,
      },
      sites: [],
      reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
    }
  },
  computed: {
    trashSubject () {
      if (this.trashObject) {
        return this.trashObject.name
      }

      if (this.checkedRows.length) {
        return `${this.checkedRows.length} entries`
      }

      return null
    }
  },
  created () {
    this.getData()
    this.getSites()
  },
  methods: {
    getData () {
      this.isLoading = true
      axios
        .get('/staff')
        .then(r => {
          this.isLoading = false
          if (r.data && r.data.data) {
            if (r.data.data.length > this.perPage) {
              this.paginated = true
            }
            this.clients = r.data.data
          }
        })
        .catch( err => {
          this.isLoading = false
          this.$buefy.toast.open({
            message: `Error: ${err.message}`,
            type: 'is-danger',
            queue: false
          })
        })
    },
    getSites () {
      axios
        .get('/sites')
        .then(r => {
          this.sites = r.data.data
        })
        .catch( err => {
          this.$buefy.toast.open({
            message: `Error: ${err.message}`,
            type: 'is-danger',
            queue: false
          })
        })
    },
    submitModal () {
      this.checkIsReadyToSend();
      if (this.isReadyToSend) {
        let method = 'post'
        let url = '/staff/invite'
        axios({
          method,
          url,
          data: this.modal
        }).then(r => {
            this.modalHandler = false;
            this.$buefy.snackbar.open({
              message: 'Отправлено',
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
      }else{
        this.$buefy.toast.open({
            message: 'Заполните оба поля и проверте правильность email',
            type: 'is-danger',
            queue: false
          })
      }
    },
    checkIsReadyToSend(){
      if(this.modal.site && this.modal.email && this.reg.test(this.modal.email)){
          this.isReadyToSend = true
      }
        
    },
    trashModal (trashObject = null) {
      if (trashObject || this.checkedRows.length) {
        this.trashObject = trashObject
        this.isModalActive = true
      }
    },
    trashConfirm () {
      let url
      let method
      let data = null

      this.isModalActive = false

      if (this.trashObject) {
        method = 'delete'
        url = `/staff/${this.trashObject.id}/destroy`
      } else if (this.checkedRows.length) {
        method = 'post'
        url = '/staff/destroy'
        data = {
          ids: map(this.checkedRows, row => row.id)
        }
      }

      axios({
        method,
        url,
        data
      }).then( r => {
        this.getData()

        this.trashObject = null
        this.checkedRows = []

        this.$buefy.snackbar.open({
          message: `Удален`,
          queue: false
        })
      }).catch( err => {
        this.$buefy.toast.open({
          message: `Error: ${err.message}`,
          type: 'is-danger',
          queue: false
        })
      })
    },
    trashCancel () {
      this.isModalActive = false
    }
  }
}
</script>
