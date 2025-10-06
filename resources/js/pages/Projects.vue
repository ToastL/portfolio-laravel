<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { projects } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Table } from '@/components/ui/table';
import { CreateProjectModal } from '@/components/projects';

interface Project {
    id: number;
    name: string;
    description_nl: string;
    description_en: string;
    image: string;
    url: string;
    github_url: string;
    created_at: string;
    updated_at: string;
}

const props = defineProps<{
    projects: Project[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projects',
        href: projects().url,
    },
];

const columns = ref([
    { key: 'id', label: '#', sortable: true },
    { key: 'name', label: 'Name', sortable: true, },
    { key: 'description_nl', label: 'Description (NL)', sortable: false },
    { key: 'description_en', label: 'Description (EN)', sortable: false },
    { key: 'image', label: 'Image', sortable: false },
    { key: 'url', label: 'URL', sortable: false },
    { key: 'github_url', label: 'GitHub URL', sortable: false },
    { key: 'created_at', label: 'Created At', sortable: true },
    { key: 'updated_at', label: 'Updated At', sortable: true },

]);

const isCreateModalOpen = ref(false);

</script>

<template>

    <Head title="Projects" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Projects</h1>

                <CreateProjectModal />
            </div>

            <Table :columns="columns" :data="props.projects">
                <template #cell-name="{ value }">
                    <Link :href="projects().url + '/' + value.id">{{ value }}</Link>
                </template>
            </Table>
        </div>
    </AppLayout>
</template>