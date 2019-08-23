<template>
    <div>
        <div class="flex bg-blue-900">
            <div class="p-4 flex flex-col">
                <h1 class="text-lg lg:text-2xl text-white font-semibold mb-2">Undelivered {{ type | capitalize }} vouchers</h1>
                <h2 class="text-base lg:text:sm text-white font-semibold">By week</h2>
            </div>
            <div class="ml-auto p-4 whitespace-no-wrap">
                <portal-target :name="`dropdown-summary-${type}`" slim />
                <dropdown class="block" placement="bottom-end" :name="`dropdown-summary-${type}`">
                    <svg class="fill-white w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
                    <div slot="dropdown" class="flex flex-col justify-between mt-2 px-8 py-4 shadow-lg bg-white border-2 border-blue-500 rounded">
                        <inertia-link v-if="group" :href="route('summary.show', { date: timestamp })" class="uppercase text-base text-blue-900 font-semibold hover:text-blue-400 px-2 py-1">
                            View
                        </inertia-link>
                        <a :href="route('summary.pdf.show', { date: timestamp })" target="_blank" class="uppercase text-base text-blue-900 font-semibold hover:text-blue-400 px-2 py-1" @click="hideDropdown()">
                            Pdf
                        </a>
                    </div>
                </dropdown>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="flex justify-between bg-gray-400 border-l border-r border-b border-blue-300 p-4">
                <span class="text-lg text-gray-800 font-semibold">
                    Schedule
                </span>
                <span class="text-lg text-gray-800 font-semibold">
                    Quantity
                </span>
            </div>
            <div v-for="(total, week) in data.summary" :key="week" class="flex justify-between border-l border-r border-b border-blue-300 p-4">
                <span class="text-lg text-gray-800 font-normal">
                    {{ week }}
                </span>
                <span class="text-lg text-gray-800 font-normal">
                    {{ total }}
                </span>
            </div>
            <div class="flex justify-between bg-gray-400 border-l border-r border-b border-blue-300 p-4">
                <span class="text-lg text-gray-800 font-semibold">
                    Total
                </span>
                <span class="text-lg text-gray-800 font-semibold">
                    {{ data.total }}
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import Dropdown from '@/Shared/Dropdown.vue';

export default {
    components: { Dropdown },
    props: ['data', 'type', 'timestamp', 'group'],
}
</script>
