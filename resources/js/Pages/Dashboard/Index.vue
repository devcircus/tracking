<template>
    <layout title="Dashboard">
        <div class="flex w-full flex-wrap lg:-mx-2">
            <inventory-preview :results="inventory" />
            <reports-preview :results="orders" />
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import ReportsPreview from '@/Pages/Reports/ReportsPreview';
import InventoryPreview from '@/Pages/Inventory/InventoryPreview';

export default {
    components: {
        Layout,
        ReportsPreview,
        InventoryPreview,
    },
    props: ['orders', 'inventory'],
}
</script>
