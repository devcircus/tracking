<template>
    <layout title="Dashboard">
        <div class="flex w-full flex-wrap md:-mx-2">
            <inventory-preview :results="inventory" />
            <orders-preview :results="orders" />
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import OrdersPreview from '@/Pages/Orders/OrdersPreview';
import InventoryPreview from '@/Pages/Inventory/InventoryPreview';

export default {
    components: {
        Layout,
        OrdersPreview,
        InventoryPreview,
    },
    props: ['orders', 'inventory'],
}
</script>
