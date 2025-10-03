<script setup lang="ts">
import { cn } from '@/lib/utils';
import { ref } from 'vue';
import { ToggleGroupRoot, ToggleGroupItem } from 'reka-ui';
import { TextAlignStart, TextAlignCenter, TextAlignEnd, Bold, Italic, Strikethrough } from 'lucide-vue-next';
import { useVModel } from '@vueuse/core';

const props = defineProps<{
  defaultValue?: string;
  modelValue?: string;
  id?: string;
  class?: string;
  placeholder?: string;
}>();

const textAlign = ref<'left' | 'center' | 'right'>('left');
const fontWeight = ref<'bold' | 'italic' | 'strikethrough'>('bold');

const toggleGroupItemClasses = 'dark:bg-input/30 data-[state=on]:dark:bg-input/50 bg-transparent flex h-7 w-8 items-center justify-center px-2 transition-[background-color,box-shadow] outline-none';

const emits = defineEmits<{
  (e: 'update:modelValue', payload: string | number): void
}>()

const modelValue = useVModel(props, 'modelValue', emits, {
  passive: true,
  defaultValue: props.defaultValue,
})
</script>

<template>
  <div class="flex flex-col gap-2">
        <div class="flex gap-2">
            <ToggleGroupRoot v-model="textAlign" class="inline-flex border rounded-md shadow-xs">
                <ToggleGroupItem value="left" :class="toggleGroupItemClasses">
                    <TextAlignStart />
                </ToggleGroupItem>
                <ToggleGroupItem value="center" :class="toggleGroupItemClasses">
                    <TextAlignCenter />
                </ToggleGroupItem>
                <ToggleGroupItem value="right" :class="toggleGroupItemClasses">
                    <TextAlignEnd />
                </ToggleGroupItem>
            </ToggleGroupRoot>
            <ToggleGroupRoot v-model="fontWeight" class="inline-flex border rounded-md shadow-xs">
                <ToggleGroupItem value="left" :class="toggleGroupItemClasses">
                    <Bold />
                </ToggleGroupItem>
                <ToggleGroupItem value="center" :class="toggleGroupItemClasses">
                    <Italic />
                </ToggleGroupItem>
                <ToggleGroupItem value="right" :class="toggleGroupItemClasses">
                    <Strikethrough />
                </ToggleGroupItem>
            </ToggleGroupRoot>
        </div>
        <textarea :id="props.id" v-model="modelValue" :placeholder="props.placeholder" :class="cn(
            'placeholder:text-muted-foreground dark:bg-input/30 border-input flex h-20 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm',
            'focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]',
            'aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive',
            props.class,
        )"></textarea>
    </div>
</template>