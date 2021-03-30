<template>
    <div class="roles-container">
         <div class="cabinet-content__header">
            <div class="cabinet-content__title" v-text="'Роли Пользователя'"></div>
            <a :href="create_url" v-text="'Создать'" class="btn btn-primary" ></a>
        </div>
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
                <span v-if="props.column.field === 'name'">
                    <span class="d-flex justify-content-between">
                        <a
                            href="javascript:void(0)"
                            @click="editHandler(props.row)"
                            :title="props.row.name"
                            v-text="props.row.name"></a>
                    </span>
                </span>
                <span v-else-if="props.column.field === 'settings'">
                    <i @click="destroyRow(props.row)" class="tim-icons icon-trash-simple"></i>
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
    import Toasted from 'vue-toasted';
	Vue.use(Toasted);
    import messages from '@adminpages/constants/messages';

    export default {
        name: 'roles-list',
        props: {
            edit_url: {
                type: [String],
                default: () => null
            },
            create_url: {
                type: [String],
                default: () => null
            },
            constant_roles: {
                type: [Object],
                default: () => []
            },
            constant_roles_warning: {
                type: [Object],
                default: () => {constantRoleWarning: 'Зщищённый параметр'}
            },
        },
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
                        label: 'Название роли',
                        field: 'name',
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
                        label: '',
                        field: 'settings',
                        type: 'text',
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
                urlGet: '/roles',
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
                    queryParams: params
                };
                axios.get(`/admin${this.urlGet}/data`, {params: paramData}).then(resp => {
                    this.rows = resp.data.rows;
                    this.totalRows = resp.data.count;
                });
            },
            onPageChange: function (params) { pageChange(params, this) },
            onSortChange: function (params) { sortChange(params, this) },
            onColumnFilter: function (params) { columnFilter(params, this) },
            onPerPageChange: function (params) { perPageChange(params, this) },
            editHandler: function (row) {
                if(!this.isConstant(row)) {
                    const url = this.edit_url.replace('default', row.id);
                    window.open(url, '_self');
                }
            },
            isConstant: function (row) {
                if(this.constant_roles && Object.values(this.constant_roles).includes(row.code)) {
                    this.messageHandler(this.constant_roles_warning.constantRoleWarning, 'info');
                    return true;
                }
                return false;
            },
            successResponse: function () {
                this.errors = {};
                this.messageHandler(messages.success.saved, 'success');
            },
            messageHandler: function(message, type) {
                let myToast = this.$toasted.show(messages.error.system, {type: type});
                myToast.text(message).goAway(2000);
            },
            destroyRow: function (data) {
                if (window.confirm('Действительно желаете удалить роль')) {
                    if (!this.isConstant(data)) {
                        axios.delete(`/admin${this.urlGet}/${data.id}`).then(resp => {
                            this.successResponse();
                            this.getData(this.currentTableParams);
                        });
                    }
                }
            },
        }
    }
</script>

