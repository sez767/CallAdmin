<template>
  <div>
    <title-bar :title-stack="['CallAdmin', 'Звонки']"/>
    <hero-bar>
      Звонки
      <router-link slot="right" to="/" class="button">
        На главную
      </router-link>
    </hero-bar>
    <section class="section is-main-section">
      <card-component class="has-table has-mobile-sort-spaced" icon="account-multiple">
        <card-toolbar>
          <button slot="right" type="button" class="button is-danger is-small has-checked-rows-number" @click="trashModal(null)" :disabled="!checkedRows.length">
            <b-icon icon="trash-can" custom-size="default"/>
            <span>Удалить выбраные</span>
            <span v-show="!!checkedRows.length">({{ checkedRows.length }})</span>
          </button>
        </card-toolbar>
        <modal-box
          :is-active="isModalActive"
          :trash-object-name="trashSubject"
          @confirm="trashConfirm"
          @cancel="trashCancel"
        />
        <b-table
          :checked-rows.sync="checkedRows"
          :checkable="true"
          :loading="isLoading"
          :paginated="paginated"
          :per-page="perPage"
          :striped="true"
          :hoverable="true"
          default-sort="id"
          :data="calls">

            <b-table-column class="has-no-head-mobile is-image-cell" v-slot="props">
              <div v-if="props.row.avatar" class="image">
                <img :src="props.row.avatar" class="is-rounded">
              </div>
            </b-table-column>
            <b-table-column label="ID" field="id" sortable v-slot="props">
              {{ props.row.id}}
            </b-table-column>
            <b-table-column label="Клиент" field="name" sortable v-slot="props">
              {{ props.row.client}}
            </b-table-column>
            <b-table-column label="Сайт" field="site" sortable v-slot="props">
              {{ props.row.site.url }}
            </b-table-column>
            <b-table-column label="Статус" field="status" sortable v-slot="props">
              {{ props.row.status }}
            </b-table-column>
            <b-table-column label="Дата" field="date" sortable v-slot="props">
              {{format_date(props.row.created_at)}}
            </b-table-column>
            <b-table-column label="Продолжительность" field="time" sortable v-slot="props">
              {{dateDiff(props.row.created_at, props.row.updated_at)}}
            </b-table-column>
            <b-table-column label="Оператор" field="staff" sortable v-slot="props">
              {{ props.row.staff.email }}
            </b-table-column>
            <b-table-column custom-key="actions" class="is-actions-cell" v-slot="props">
              <div class="buttons is-right">
                <router-link :to="{name:'calls.edit', params: {id: props.row.id}}" class="button is-small is-primary">
                  <b-icon icon="account-edit" size="is-small"/>
                </router-link>
                <button class="button is-small is-danger" type="button" @click.prevent="trashModal(props.row)">
                  <b-icon icon="trash-can" size="is-small"/>
                </button>
              </div>
            </b-table-column>

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
                <p>Ничего нет&hellip;</p>
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
import moment from 'moment';

export default {
  name: "CallIndex",
  components: {CardToolbar, HeroBar, TitleBar, ModalBox, CardComponent},
  data () {
    return {
      isModalActive: false,
      trashObject: null,
      calls: [],
      isLoading: false,
      paginated: false,
      perPage: 10,
      checkedRows: []
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
  },
  methods: {
    getData () {
      this.isLoading = true
      axios
        .get('/calls')
        .then(r => {
          this.isLoading = false
          if (r.data && r.data.data) {
            if (r.data.data.length > this.perPage) {
              this.paginated = true
            }
            this.calls = r.data.data
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
    dateDiff (startDateString, endDateString) {
      // let start = moment(startDateString);
      // let end = moment(endDateString);
      // let duration = moment.duration(end.diff(start));
      let duration = moment(startDateString).diff(moment(endDateString)).format("mm:ss")
      // let days = duration.asDays();
      return duration;
    },
    format_date(value){
         if (value) {
           return moment(String(value)).format('HH:mm:ss - DD.MM.YY')
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
        url = `/calls/${this.trashObject.id}/destroy`
      } else if (this.checkedRows.length) {
        method = 'post'
        url = '/calls/destroy'
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
          message: `Deleted`,
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
