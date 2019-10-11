<template>
    <div>
        <div class="flex bg-blue-900">
            <div class="p-4 flex flex-col">
                <h1 class="text-lg lg:text-2xl text-white font-semibold mb-2">Undelivered {{ type | capitalize }} vouchers</h1>
                <h2 class="text-base lg:text:sm text-white font-semibold">By week</h2>
            </div>
            <div class="ml-auto p-4 whitespace-no-wrap">
                <dropdown class="block" width="180">
                    <div slot="trigger">
                        <svg class="fill-white w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
                    </div>
                    <div slot="dropdown" class="flex flex-col justify-between mt-2 py-2 shadow-lg bg-white rounded">
                        <inertia-link :href="route('summary.show', { date: timestamp })" class="flex items-center px-3 py-2 text-gray-700 hover:bg-blue-500 hover:text-white group">
                            <icon-base view="24 24" icon-fill="fill-gray-700" icon-name="view" classes="mr-2 group-hover:fill-white">
                                <view-eye />
                            </icon-base>
                            <span v-if="group" class="uppercase text-base text-blue-900 font-semibold py-1 group-hover:text-white">
                                View
                            </span>
                        </inertia-link>
                        <a :href="route('summary.pdf.show', { date: timestamp })" target="_blank" class="flex items-center px-3 py-2 text-gray-700 hover:bg-blue-500 hover:text-white group" @click="hideDropdown()">
                            <icon-base width="14" height="14" icon-fill="fill-gray-700" icon-name="printable" classes="mr-2 group-hover:fill-white">
                                <printer />
                            </icon-base>
                            <span class="uppercase text-base text-blue-900 font-semibold py-1 group-hover:text-white">
                                Pdf
                            </span>
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
import IconBase from '@/Shared/IconBase';
import Printer from '@/Shared/Icons/Printer';
import ViewEye from '@/Shared/Icons/ViewEye';
import Dropdown from '@/Shared/Dropdown.vue';

export default {
    components: {
        Printer,
        ViewEye,
        IconBase,
        Dropdown,
    },
    props: ['data', 'type', 'timestamp', 'group'],
}
</script>
