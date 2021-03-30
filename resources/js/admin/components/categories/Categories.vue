<template>
    <div class="roles-container">
        <div class="cabinet-content__header">
            <div class="cabinet-content__title" v-text="'Категории'"></div>
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
                    <i class="tim-icons icon-settings-gear-63" />
                </span>
                <span v-else>
                {{props.column.label}}
                </span>
            </template>
            <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field === 'name_ua'">
                    <span class="d-flex justify-content-between">
                        <a
                            href="javascript:void(0)"
                            @click="editHandler(props.row)"
                            :title="props.row.name_ua"
                            v-text="props.row.name_ua"></a>
                    </span>
                </span>
                <span v-else-if="props.column.field === 'active'">
                    <input
                        class="mr-3"
                        name="active"
                        :id="`category_active_${props.row.id}`"
                        type="checkbox"
                        :checked="props.row.active"
                        @change="changeStatus(props.row, $event)"
                    />
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
        name: 'categories-list',
        props: {
            edit_url: {
                type: [String],
                default: () => null
            },
            create_url: {
                type: [String],
                default: () => null
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
                        label: 'Название (ua)',
                        field: 'name_ua',
                        type: 'text',
                        sortable: true,
                        filterOptions: {
                            enabled: true, // enable filter for this column
                            placeholder: vgtLabels.placeholder,
                        },
                    },
                    {
                        label: 'Название (ru)',
                        field: 'name_ru',
                        type: 'text',
                        sortable: true,
                        filterOptions: {
                            enabled: true, // enable filter for this column
                            placeholder: vgtLabels.placeholder,
                        },
                    },
                    {
                        label: 'Название (en)',
                        field: 'name_en',
                        type: 'text',
                        sortable: true,
                        filterOptions: {
                            enabled: true, // enable filter for this column
                            placeholder: vgtLabels.placeholder,
                        },
                    },
                    {
                        label: 'Статус',
                        field: 'active',
                        type: 'text',
                        sortable: true,
                        filterOptions: {
                            enabled: false,
                        },
                        width: '100px',
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
                   field: 'id',
                   type: 'asc'
                }],
                urlGet: '/categories',
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
                const url = this.edit_url.replace('default', row.id);
                window.open(url, '_self');
            },
            successResponse: function () {
                this.errors = {};
                this.messageHandler(messages.success.saved, 'success');
            },
            messageHandler: function(message, type) {
                let myToast = this.$toasted.show(messages.error.system, {type: type});
                myToast.text(message).goAway(2000);
            },
            changeStatus: function (data, event) {
                if (window.confirm('Действительно желаєте сменить статус')) {
                    axios.post(`/admin${this.urlGet}/changeStatus`, {category: {id: data.id}})
                            .then(resp => this.successResponse() );
                } else {
                    event.target.checked = !event.target.checked;
                }
            },
            destroyRow: function (data) {
                if (window.confirm('Действительно желаете удалить категорию')) {
                    axios.delete(`/admin${this.urlGet}/${data.id}`).then(resp => {
                        this.successResponse();
                        this.getData(this.currentTableParams);
                    });
                }
            },
        }
    }
</script>
