<template>
  <div>
    <title-bar :title-stack="['CallAdmin', 'Заявки']"/>
    <hero-bar>
      Заявки
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
          defaultSortDirection="desc"
          :data="callreq">

            <b-table-column class="has-no-head-mobile is-image-cell" v-slot="props">
              <div v-if="props.row.avatar" class="image">
                <img :src="props.row.avatar" class="is-rounded">
              </div>
            </b-table-column>
            <b-table-column label="ID" field="id" sortable v-slot="props">
              {{ props.row.id }}
            </b-table-column>
            <b-table-column label="Статус" field="status" sortable v-slot="props"> 
              <b-icon v-if="props.row.status == 1" icon="bell-check" size="is-big" style="color:green;"/>
              <b-icon v-else icon="bell-alert" size="is-big" style="color:red;"/>
            </b-table-column>
            <b-table-column label="Имя" field="name" sortable v-slot="props">
              {{ props.row.name }}
            </b-table-column>
            <b-table-column label="Телефон" field="phone" sortable v-slot="props">
              {{ props.row.phone }}
            </b-table-column>
            <b-table-column label="Сайт" field="site" sortable v-slot="props">
              {{ props.row.sites.url }}
            </b-table-column>
            <b-table-column label="Дата подачи" field="date" sortable v-slot="props">
              {{format_date(props.row.created_at)}}
            </b-table-column>
            <b-table-column label="Дата обработки" field="wdate" sortable v-slot="props">
              {{format_date(props.row.updated_at)!=format_date(props.row.created_at)? format_date(props.row.updated_at):''}}
            </b-table-column>
            <b-table-column label="Оператор" field="staff" sortable v-slot="props">
            <span v-if="props.row.staffs">{{ props.row.staffs.email }}</span>  
            </b-table-column>
            <b-table-column label="Коментарий" field="comment" sortable v-slot="props">
              {{ props.row.comment }}
            </b-table-column>
            <b-table-column custom-key="actions" class="is-actions-cell" v-slot="props">
              <div class="buttons is-right">
                <button class="button is-small is-primary" type="button" @click.prevent="switchStatus(props.row)">
                  <b-icon icon="check-circle" size="is-small"/>
                </button>
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
  name: "ClientIndex",
  components: {CardToolbar, HeroBar, TitleBar, ModalBox, CardComponent},
  data () {
    return {
      isModalActive: false,
      trashObject: null,
      callreq: [],
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
        .get('/callreq')
        .then(r => {
          this.isLoading = false
          if (r.data && r.data.data) {
            if (r.data.data.length > this.perPage) {
              this.paginated = true
            }
            this.callreq = r.data.data
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
    switchStatus(row){
            const url = `/callreq/${row.id}`;
            const stat = +(!row.status);
            axios.patch(url, {callrequest: {status: stat}})
                .then(response => {
                    // this.successResponse();
                    // row = response.data.data;  
                    row['status'] = response.data.data.status;
                    row['wdate'] = response.data.data.updated_at;
                    console.log('aaaaaaaaaaaaaaaaaaaaaaaa',response.data.data);
                    console.log('aaccc',response.data.data.status); 
                })
                .catch(error => {
                    this.errorParser(error);
                });
    },
    format_date(value){
         if (value) {
           return moment(String(value)).format('HH:mm:ss - DD.MM')
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
        url = `/callreq/${this.trashObject.id}/destroy`
      } else if (this.checkedRows.length) {
        method = 'post'
        url = '/callreq/destroy'
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
