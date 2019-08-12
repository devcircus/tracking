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
            tdClass: 'column-left',
            thClass: 'column-left',
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
}
