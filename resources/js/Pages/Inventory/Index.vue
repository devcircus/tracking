<template>
    <layout title="Dashboard">
        <div class="flex w-full flex-wrap lg:-mx-2">
            <div class="flex flex-col w-full lg:w-1/3 lg:px-2">
                <activate-tag :items="items" :tags="tags" class="w-full mb-4" />
                <activate-multiple-tags :items="items" :tags="tags" class="w-full mb-4" />
            </div>
            <div class="flex flex-col w-full lg:w-2/3 lg:px-2">
                <tag-list :tags="tags" class="w-full mb-4" />
                <div class="flex flex-wrap w-full lg:-mx-2">
                    <item-list :items="items" class="w-full lg:w-1/2 lg:px-2 mb-4" />
                    <finish-multiple-tags class="w-full lg:w-1/2 lg:px-2 mb-4" />
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import TagList from '@/Partials/Tags/TagList';
import ItemList from '@/Partials/Items/ItemList';
import ActivateTag from '@/Partials/Tags/ActivateTag';
import FinishMultipleTags from '@/Partials/Tags/FinishMultipleTags';
import ActivateMultipleTags from '@/Partials/Tags/ActivateMultipleTags';

export default {
    components: {
        Layout,
        TagList,
        ItemList,
        ActivateTag,
        FinishMultipleTags,
        ActivateMultipleTags,
    },
    props: ['items', 'tags'],
}
</script>
