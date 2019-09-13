import { config } from 'Config';

export default {
    meta: {
        admin: {
            name: config.admin.name,
            email: config.admin.email,
            sites: {
                github: {
                    profile: config.admin.sites.github.profile,
                    url: config.admin.sites.github.url,
                },
                twitter: {
                    profile: config.admin.sites.twitter.profile,
                    url: config.admin.sites.twitter.url,
                },
            },
        },
        links: {
            template: {
                name: config.links.template.name,
                url: config.links.template.url,
            },
            local: {
                tasks: {
                    name: config.links.local.tasks.name,
                    url: config.links.local.tasks.url,
                },
                corporate: {
                    name: config.links.local.corporate.name,
                    url: config.links.local.corporate.url,
                },
            },
        },
    },
    tagColumns: [
        {
            field: 'package_number',
            label: 'Package',
            type: 'number',
            tdClass: 'text-left',
            thClass: 'text-left',
            width: '100px',
            sortable: true,
        },
        {
            field: 'item.name',
            label: 'Item',
            type: 'text',
            sortable: true,
        },
        {
            field: 'received_at',
            label: 'Received',
            type: 'date',
            dateInputFormat: 'yyyy-LL-dd',
            dateOutputFormat: 'yyyy-LL-dd',
            hidden: false,
            sortable: true,
        },
        {
            field: 'finished_at',
            label: 'Finished',
            type: 'date',
            dateInputFormat: 'yyyy-LL-dd',
            dateOutputFormat: 'yyyy-LL-dd',
            hidden: false,
            sortable: true,
        },
        {
            field: 'actions',
            label: 'Actions',
        },
    ],
    tagSortOptions: {
        enabled: true,
        initialSortBy: [
            { field: 'received_at', type: 'desc' },
            { field: 'package_number', type: 'desc' },
        ],
    },
    tagPaginationOptions: {
        enabled: true,
        mode: 'pages',
        perPage: 8,
        dropdownAllowAll: true,
        nextLabel: 'next',
        prevLabel: 'prev',
        rowsPerPageLabel: 'Records per page',
        ofLabel: 'of',
        pageLabel: 'page',
        allLabel: 'All',
    },
    tagSearchOptions: {
        enabled: true,
        placeholder: 'Search tags...',
    },
    itemColumns: [
        {
            field: 'name',
            label: 'Item',
            type: 'text',
            sortable: true,
        },
        {
            field: 'tags_count',
            label: 'In Stock',
            type: 'number',
            sortable: true,
        },
        {
            field: 'actions',
            label: 'Actions',
            sortable: false,
        },
    ],
    itemSearchOptions: {
        enabled: true,
        placeholder: 'Search items...',
    },
    itemSortOptions: {
        enabled: true,
        initialSortBy: [
            { field: 'name', type: 'asc' },
        ],
    },
    itemPaginationOptions: {
        enabled: true,
        mode: 'pages',
        perPage: 8,
        dropdownAllowAll: true,
        nextLabel: 'next',
        prevLabel: 'prev',
        rowsPerPageLabel: 'Records per page',
        ofLabel: 'of',
        pageLabel: 'page',
        allLabel: 'All',
    },
    activityColumns: [
        {
            field: 'created_at',
            label: 'Timestamp',
            type: 'date',
            dateInputFormat: 'yyyy-LL-dd HH:mm:ss',
            dateOutputFormat: 'yyyy-LL-dd h:mm aaa',
            tdClass: 'text-left',
            thClass: 'text-left',
            width: '220px',
            sortable: true,
        },
        {
            field: 'causer.name',
            label: 'User',
            type: 'text',
            sortable: true,
        },
        {
            field: 'description',
            label: 'Action',
            type: 'text',
            sortable: true,
        },
        {
            field: 'subject_type',
            label: 'Subject',
            type: 'text',
            sortable: true,
        },
        {
            field: 'properties.target',
            label: 'Data',
        },
    ],
    activitySortOptions: {
        enabled: true,
        initialSortBy: [
            { field: 'created_at', type: 'desc' },
        ],
    },
    activityPaginationOptions: {
        enabled: true,
        mode: 'pages',
        perPage: 10,
        dropdownAllowAll: true,
        nextLabel: 'next',
        prevLabel: 'prev',
        rowsPerPageLabel: 'Records per page',
        ofLabel: 'of',
        pageLabel: 'page',
        allLabel: 'All',
    },
    activitySearchOptions: {
        enabled: true,
        placeholder: 'Search activities...',
    },
    artworkColumns: [
        {
            field: 'schedule_date',
            label: 'Scheduled',
            type: 'date',
            dateInputFormat: 'yyyy-LL-dd',
            dateOutputFormat: 'yyyy-LL-dd',
            tdClass: 'text-left',
            thClass: 'text-left',
            width: '160px',
            sortable: true,
        },
        {
            field: 'order_number',
            label: 'Order',
            type: 'number',
            sortable: true,
        },
        {
            field: 'voucher',
            label: 'Voucher',
            type: 'text',
            sortable: false,
        },
        {
            field: 'customer',
            label: 'Customer',
            width: '300px',
            type: 'text',
            sortable: true,
        },
        {
            field: 'style',
            label: 'Style',
            type: 'text',
            sortable: true,
        },
        {
            field: 'art_complete',
            label: 'Complete',
            type: 'date',
            dateInputFormat: 'yyyy-LL-dd HH:mm:ss',
            dateOutputFormat: 'LL-dd',
            sortable: true,
        },
        {
            field: 'actions',
            label: 'Actions',
            sortable: false,
        },
    ],
    artworkSortOptions: {
        enabled: true,
        initialSortBy: [
            { field: 'schedule_date', type: 'asc' },
        ],
    },
    artworkSearchOptions: {
        enabled: true,
        placeholder: 'Search prototypes...',
    },
    colorColumns: [
        {
            field: 'code',
            label: 'Code',
            type: 'text',
            sortable: true,
        },
        {
            field: 'name',
            label: 'Name',
            type: 'text',
            sortable: true,
        },
        {
            field: 'type',
            label: 'Type',
            type: 'text',
            sortable: true,
        },
    ],
    colorSortOptions: {
        enabled: true,
        initialSortBy: [
            { field: 'code', type: 'asc' },
        ],
    },
    colorPaginationOptions: {
        enabled: true,
        mode: 'pages',
        perPage: 10,
        dropdownAllowAll: true,
        nextLabel: 'next',
        prevLabel: 'prev',
        rowsPerPageLabel: 'Records per page',
        ofLabel: 'of',
        pageLabel: 'page',
        allLabel: 'All',
    },
    colorSearchOptions: {
        enabled: true,
        placeholder: 'Search colors...',
    },
    fabricColumns: [
        {
            field: 'code',
            label: 'Code',
            type: 'text',
            sortable: true,
        },
        {
            field: 'name',
            label: 'Name',
            type: 'text',
            sortable: true,
        },
        {
            field: getCrossGrain,
            label: 'Cross-Grain',
            type: 'boolean',
        },
        {
            field: 'press_speed',
            label: 'Press Speed',
            type: 'number',
        },
    ],
    fabricSortOptions: {
        enabled: true,
        initialSortBy: [
            { field: 'code', type: 'asc' },
            { field: 'name', type: 'asc' },
        ],
    },
    fabricPaginationOptions: {
        enabled: true,
        mode: 'pages',
        perPage: 10,
        dropdownAllowAll: true,
        nextLabel: 'next',
        prevLabel: 'prev',
        rowsPerPageLabel: 'Records per page',
        ofLabel: 'of',
        pageLabel: 'page',
        allLabel: 'All',
    },
    fabricSearchOptions: {
        enabled: true,
        placeholder: 'Search fabrics...',
    },
    printerColumns: [
        {
            field: 'name',
            label: 'Name',
            type: 'text',
            sortable: true,
        },
        {
            field: 'model',
            label: 'Model',
            type: 'text',
            sortable: true,
        },
        {
            field: getInkInfo,
            label: 'Ink',
            type: 'text',
        },
        {
            field: 'ink.type',
            label: 'Ink Type',
            type: 'text',
            sortable: false,
        },
        {
            field: 'manufacturer',
            label: 'Manufacturer',
            type: 'text',
            sortable: true,
        },
        {
            field: 'colors',
            label: 'Colors',
            sortable: false,
        },
    ],
    printerColorColumns: [
        {
            field: 'code',
            label: 'Code',
            type: 'text',
            sortable: true,
        },
        {
            field: 'name',
            label: 'Name',
            type: 'text',
            sortable: true,
        },
        {
            field: 'type',
            label: 'Type',
            type: 'text',
            sortable: false,
        },
        {
            field: getColorApproved,
            label: 'Approved',
            type: 'boolean',
            sortable: true,
        },
        {
            field: concatenateCmyk,
            label: 'CMYK',
            type: 'text',
            sortable: false,
        },
    ],
    printerColorSortOptions: {
        enabled: true,
        initialSortBy: [
            { field: 'code', type: 'asc' },
        ],
    },
    printerColorSearchOptions: {
        enabled: true,
        placeholder: 'Search colors...',
    },
    inkColumns: [
        {
            field: 'manufacturer',
            label: 'Manufacturer',
            type: 'text',
        },
        {
            field: 'version',
            label: 'Version',
            type: 'text',
        },
        {
            field: 'type',
            label: 'Type',
            type: 'text',
        },
    ],
    inkSortOptions: {
        enabled: true,
        initialSortBy: [
            { field: 'manufacturer', type: 'asc' },
            { field: 'version', type: 'asc' },
        ],
    },
}

function getCrossGrain (fabric) {
    return fabric.cross_grain == 1 ? 'true' : 'false';
}

function getColorApproved (color) {
    return color.pivot.approved == 1 ? 'true' : 'false';
}

function concatenateCmyk (color) {
    return `${color.pivot.cyan}-${color.pivot.magenta}-${color.pivot.yellow}-${color.pivot.black}`;
}

function getInkInfo (printer) {
    return `${printer.ink.manufacturer}-${printer.ink.version}`;
}
