<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { tools } from '@/routes';
import { ref } from 'vue';
import { ToolModal } from '@/components/modals';
import { Table } from '@/components/ui/table';

interface Tool {
    id: number;
    name: string;
    image: string;
    created_at: string;
    updated_at: string;
}

const props = defineProps<{
    tools: Tool[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tools',
        href: tools().url,
    },
];

const columns = ref([
    { key: 'id', label: '#', sortable: true },
    { key: 'name', label: 'Name', sortable: true, },
    { key: 'image', label: 'Image', sortable: false },
    { key: 'created_at', label: 'Created At', sortable: true },
    { key: 'updated_at', label: 'Updated At', sortable: true }
]);

const actions = ref([
    { key: 'delete', label: 'Delete' },
])
</script>

<template>
    <Head title="Tools" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Tools</h1>

                <ToolModal />
            </div>

            <Table :route="tools().url" :columns="columns" :actions="actions" :data="props.tools">
                <template #cell-name="{ value }">
                    <Link :href="tools().url + '/' + value.id">{{ value }}</Link>
                </template>
            </Table>
        </div>
    </AppLayout>
</template>