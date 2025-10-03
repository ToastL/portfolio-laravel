<script setup lang="ts">
interface Column {
    key: string;
    label: string;
    sortable?: boolean;
}

const props = defineProps<{
    columns: Column[];
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
                </tr>
            </tbody>
        </table>
    </div>
</template>