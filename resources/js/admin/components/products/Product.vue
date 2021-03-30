<template>
    <div class="products-container">
        <div class="cabinet-content__header">
            <div class="cabinet-content__title" v-text="'Товары'"></div>
            <a href="/admin/products/create" v-text="'Создать'" class="btn btn-primary" ></a>
        </div>
       <!-- <div class="col-12 text-right">
        <a href="/admin/products/create" class="btn btn-primary">Создать</a>
       </div> -->
        <vue-good-table
            :columns="columns"
            :rows="rows"
            :pagination-options="paginationOptions"
            styleClass="vgt-table striped"
            :totalRows="totalRows"
            mode="remote"
            @on-page-change="onPageChange"
            @on-sort-change="onSortChange"
            @on-column-filter="onColumnFilter"
            @on-per-page-change="onPerPageChange"
            theme="polar-bear"
        >
            <template slot="table-column" slot-scope="props">
                <span v-if="props.column.field === 'settings'" class="custom-header-settings">
                    <i class="fa fa-cogs" />
                </span>
                <span v-else>
                {{props.column.label}}
                </span>
            </template>
            <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field === 'title'">
                    
               </span>
                
                <span v-else-if="props.column.field === 'settings'">
                    <a 
                    :href="'/admin'+urlGet+'/'+props.row.id+'/edit'" 
                    role="button">
                        <i class="cursore tim-icons icon-pencil"></i>
                    </a>
                    <i @click="destroyRow(props.row)" style="cursor: pointer;" class="cursore tim-icons icon-trash-simple" />
                </span>
                <span v-else>
                    {{props.row[props.column.field]}}
                </span>
            </template>
            <div slot="emptystate" v-text="vgtLabels.emptyData" class="text-center" />
        </vue-good-table>
    </div>
</template>

<script>
    import {
            paginationOptions, pageChange, sortChange, columnFilter, perPageChange, initialQueryParams, vgtLabels
        } from '@adminpages/constants/vgt';

    export default {
        name: 'products-list',
        data() {
            return {
                rows: [],
                paginationOptions: paginationOptions(this),
                totalRows: 0,
                currentPerPage: 10,
                filterData: null,
                columns: [
                    {
                        label: 'ID',
                        field: 'id',
                        type: 'text',
                        sortable: true,
                        filterOptions: {
                            enabled: true, // enable filter for this column
                            placeholder: vgtLabels.placeholder,
                        },
                        width: '50px'
                    },
                    {
                        label: 'Название (ru)',
                        field: 'name_ua',
                        type: 'text',
                        sortable: true,
                        filterOptions: {
                            enabled: true, // enable filter for this column
                            placeholder: vgtLabels.placeholder,
                        },
                    },
                    {
                        label: 'Код',
                        field: 'code',
                        type: 'text',
                        sortable: true,
                        filterOptions: {
                            enabled: true, // enable filter for this column
                            placeholder: vgtLabels.placeholder,
                        },
                    },
                    {
                        label: 'Изготовитель',
                        field: 'manufacturer',
                        type: 'text',
                        sortable: true,
                        filterOptions: {
                            enabled: true, // enable filter for this column
                            placeholder: vgtLabels.placeholder,
                        },
                    },
                    {
                        label: 'Количество',
                        field: 'amount',
                        type: 'text',
                        sortable: true,
                        filterOptions: {
                            enabled: true, // enable filter for this column
                            placeholder: vgtLabels.placeholder,
                        },
                    },
                    {
                        label: 'Цена',
                        field: 'price',
                        type: 'text',
                        sortable: true,
                        filterOptions: {
                            enabled: true, // enable filter for this column
                            placeholder: vgtLabels.placeholder,
                        },
                    },
                    {
                        label: '',
                        field: 'settings',
                        type: 'text',
                        width: '80px',
                        sortable: false,
                        filterOptions: {
                            enabled: false, // enable filter for this column
                        },
                        html: true,
                    }
                ],
                sorting: [{
                   field: 'created_at',
                   type: 'desc'
                }],
                urlGet: '/products',
                currentTableParams: null,
                vgtLabels: vgtLabels,
            }
        },
        created() {
            this.getData(initialQueryParams(this));
        },
        methods: {
            getData: function (params) {
                this.currentTableParams = params;
                let paramData = {
                    queryParams: params,
                    role: this.role
                };
                axios.get(`/admin/product/data`, {params: paramData}).then(resp => {
                    this.rows = resp.data.rows;
                    this.totalRows = resp.data.count;
                });
            },
            onPageChange: function (params) { pageChange(params, this) },
            onSortChange: function (params) { sortChange(params, this) },
            onColumnFilter: function (params) { columnFilter(params, this) },
            onPerPageChange: function (params) { perPageChange(params, this) },
            editHandler: function (row) {
               this.$router.push({name: 'updateExam', params: {examId: row.id}});
            },
            successResponse: function () {
                this.errors = {};
                this.messageHandler('Успішно', 'success');
            },
            messageHandler: function(message, type) {
                let myToast = this.$toasted.show(this.$t('messages.1279'), {type: type});
                myToast.text(message).goAway(2000);
            },
            changeStatus: function (data, event) {
                this.$swal({
                    title: 'Дійсно бажаєте статус публикації?',
                    showCancelButton: true,
                    confirmButtonText: 'Так',
                    cancelButtonText: 'Ні',
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`${this.role}${this.urlGet}/${data.id}/published`)
                            .then(resp => this.successResponse() );
                    } else {
                        event.target.checked = !event.target.checked;
                    }
                });
            },
            destroyIconFire: function (row) {
                return this.canCreate && row.exercises.length === 0;
            },
            editRow(){

            },
            destroyRow(data) {
                let del = confirm('Ви впевнені що хочете видалити?')
                if (del) {
                    axios.delete(`/admin${this.urlGet}/${data.id}`).then(resp => {
                        // this.successResponse();
                        this.getData(this.currentTableParams);
                    });
                }
               
            },
            revertStatuses: function (statuses) {
                const rightStatuses = [...statuses];
                rightStatuses.map(status => {
                    status.value = +status.value === 1 ? 0 : 1;
                });
                return rightStatuses;
            },
            isNotGlobalRole: function (role) {
                const globalRoles = ['director', 'auditor', 'api_key_manager', 'super_admin'];
                return !globalRoles.includes(role);
            },
        }
    }
</script>
<style>
    .cursore{
        cursor: pointer;
    }
</style>

