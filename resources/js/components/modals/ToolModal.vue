<script setup lang="ts">
import { tools } from '@/routes';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger, DialogDescription } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

const isOpen = ref(false);

const form = useForm({
    name: '',
    image: null as File | null,
});

const submit = () => {
    form.post(tools().url, {
        method: 'put',
        forceFormData: true,
        onSuccess: () => {
            isOpen.value = false;
            form.reset()
        },
    });
}
</script>

<template>
    <Dialog v-model:open="isOpen">
        <DialogTrigger as-child>
            <Button>Add Tool</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Create Tool</DialogTitle>
                <DialogDescription>
                    Add a new tool to your portfolio.
                </DialogDescription>

                <form @submit.prevent="submit">
                    <div class="grid gap-4 grid-cols-1">
                        <div class="flex flex-col space-y-2">
                            <Label for="name">Name</Label>
                            <Input id="name" v-model="form.name" type="text" placeholder="Tool name" />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="flex flex-col space-y-2">
                            <Label for="image">Image</Label>
                            <Input id="image" type="file" accept="image/svg+xmlx" @change="form.image = $event.target.files[0]" />
                            <InputError :message="form.errors.image" />
                        </div>
                    </div>

                    <Button type="submit" :disabled="form.processing">Submit</Button>
                </form>
            </DialogHeader>
        </DialogContent>
    </Dialog>
</template>