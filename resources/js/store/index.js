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
            label: 'Package Number',
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
            label: 'Target',
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
}
