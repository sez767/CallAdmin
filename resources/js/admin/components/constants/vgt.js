export const dateInputFormat = 'yyyy-MM-dd HH:mm:ss';
export const dateOnlyInputFormat = 'yyyy-MM-dd';
export const dateOutputFormat = 'dd MMM yy';
export const dateOutputFormatDigits = 'dd.MM.yyyy';
export const vgtLabels = {
    emptyData: 'Дані відсутні',
};
const CURRENT_PER_PAGE = 20;

export function initialQueryParams (that) {
    return  {
        count: CURRENT_PER_PAGE,
        page: 1,
        sorting: that.sorting,
        filter: that.filterData
    };
}

export function paginationOptions (that) {
	return {
        enabled: true,
        position: 'bottom',
        dropdownAllowAll: false,
        setCurrentPage: 1,
        nextLabel: 'Дальше',
        prevLabel: 'Назад',
        rowsPerPageLabel: 'Рядков на сторанице',
        ofLabel: 'of',
        pageLabel: 'page', // for 'pages' mode
        allLabel: 'All',
        perPage: CURRENT_PER_PAGE,
        perPageDropdown: [CURRENT_PER_PAGE, CURRENT_PER_PAGE * 2, CURRENT_PER_PAGE * 3],
    };
}

export function pageChange (params, that) {
    that.currentPerPage = params.currentPerPage;
    let queryParams = {
        count: params.currentPerPage,
        page: params.currentPage,
        sorting: that.sorting,
        filter: that.filterData
    }
    that.getData(queryParams);
};

export function sortChange (params, that) {
    that.sorting = params;
    let queryParams = {
        count: CURRENT_PER_PAGE,
        page: that.paginationOptions.setCurrentPage,
        sorting: params,
        filter: that.filterData
    }
    that.getData(queryParams);
};

export function columnFilter (params, that) {
    const filterData = that.filterData = destroyEmptyProperies(params.columnFilters);
    let queryParams = {
        count: CURRENT_PER_PAGE,
        page: that.paginationOptions.setCurrentPage,
        sorting: that.sorting,
        filter: filterData
    };
    that.getData(queryParams);
};

export function perPageChange (params, that) {
    let queryParams = {
        count: params.currentPerPage,
        page: params.currentPage,
        sorting: that.sorting,
        filter: that.filterData
    }
    that.getData(queryParams);
};

function destroyEmptyProperies (obj) {
    for(let prop in obj) {
        if (obj[prop].length === 0) {
            delete obj[prop];
        }
    }
    return obj;
}
