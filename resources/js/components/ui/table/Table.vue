<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { cn } from '@/lib/utils';

interface Column {
    key: string;
    label: string;
    sortable?: boolean;
}

interface Action {
    key: string;
    label: string;
}

const props = defineProps<{
    route: string;
    columns: Column[];
    actions?: Action[];
    data: Record<string, any>[];
    sortBy?: string;
    sortDirection?: 'asc' | 'desc';
}>()

const emit = defineEmits<{
    sort: [column: string];
}>()

const handleSort = (column: string) => {
    emit('sort', column);
}

const handleAction = (action: string, id: string) => {
    switch (action) {
        case 'delete':
            router.delete(props.route + '/' + id + '/delete');
            break;
    }
}
</script>

<template>
    <div class="overflow-x-auto border border-sidebar-border/70 rounded-xl">
        <table class="w-full border-separate">
            <thead>
                <tr>
                    <th 
                        v-for="column in columns"
                        :key="column.key"
                        class="first:rounded-l-lg last:rounded-r-lg px-4 py-2 text-left font-medium text-muted-foreground"
                        :class="{ 'cursor-pointer hover:bg-muted/50': column.sortable }"
                        @click="column.sortable ? handleSort(column.key) : null"
                    >
                        <div class="flex items-center gap-2 text-sm">
                            {{ column.label }}
                            <span v-if="column.sortable" class="text-xs">
                                {{ sortBy === column.key ? (sortDirection === 'asc' ? '↑' : '↓') : '↕' }}
                            </span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(row, index) in data"
                    :key="index" class="rounded-xl hover:bg-muted/50"
                >
                    <td
                        v-for="column in columns"
                        :key="column.key"
                        class="first:rounded-l-lg last:rounded-r-lg px-4 py-2 text-sm truncate"
                    >
                        <slot :name="`cell-${column.key}`" :value="row[column.key]" :row="row" :index="index">
                            {{ row[column.key] }}
                        </slot>
                    </td>
                    <td
                        v-for="action in actions"
                        :key="action.key"
                        class="first:rounded-l-lg last:rounded-r-lg px-4 py-2 text-sm truncate"
                    >
                        <slot :name="`action-${row.id}`" :row="row" :index="index">
                            <button 
                                @click="handleAction(action.key, row.id)"
                                :class="cn(
                                    'text-muted-foreground hover:text-foreground px-3 cursor-pointer',
                                    action.key === 'delete' && 'text-destructive'
                                )"
                            >
                                {{ action.label }}
                            </button>
                        </slot>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>