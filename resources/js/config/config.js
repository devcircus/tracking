export const config = {
    apiUrl: process.env.MIX_API_URL,
    appName: process.env.MIX_APP_NAME,
    timezone: process.env.MIX_FRONTEND_TIMEZONE,
    algoliaId: process.env.MIX_ALGOLIA_APP_ID,
    algoliaSearch: process.env.MIX_ALGOLIA_SEARCH,
    pusherKey: process.env.MIX_PUSHER_APP_KEY,
    pusherCluster: process.env.MIX_PUSHER_APP_CLUSTER,
    admin: {
        name: process.env.MIX_ADMIN_NAME,
        email: process.env.MIX_ADMIN_EMAIL,
        sites: {
            github: {
                profile: process.env.MIX_ADMIN_GITHUB_PROFILE,
                url: process.env.MIX_ADMIN_GITHUB_URL,
            },
            twitter: {
                profile: process.env.MIX_ADMIN_TWITTER_PROFILE,
                url: process.env.MIX_ADMIN_TWITTER_URL,
            },
        },
    },
    links: {
        template: {
            name: process.env.MIX_TEMPLATE_NAME,
            url: process.env.MIX_TEMPLATE_URL,
        },
        local: {
            tasks: {
                name: process.env.MIX_LINK_TASKS_NAME,
                url: process.env.MIX_LINK_TASKS_URL,
            },
            corporate: {
                name: process.env.MIX_LINK_CORPORATE_NAME,
                url: process.env.MIX_LINK_CORPORATE_URL,
            },
        },
    },
}
