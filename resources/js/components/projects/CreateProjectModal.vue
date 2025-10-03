<script setup lang="ts">
import { projects } from '@/routes/projects';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger, DialogDescription } from '@/components/ui/dialog';
import { Input, Textarea } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

const isOpen = ref(false);

const form = useForm({
    name: '',
    description_nl: '',
    description_en: '',
    image: '',
    url: '',
    github_url: '',
});

const submit = () => {
    form.post(projects.store().url);
    isOpen.value = false;
}
</script>

<template>
    <Dialog v-model:open="isOpen">
        <DialogTrigger as-child>
            <Button>Add Project</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Create Project</DialogTitle>
                <DialogDescription>
                    Add a new project to your portfolio.
                </DialogDescription>

                <form @submit.prevent="submit">
                    <div class="grid gap-4 grid-cols-1">
                        <div class="flex flex-col space-y-2">
                            <Label for="name">Name</Label>
                            <Input id="name" v-model="form.name" type="text" placeholder="Project name" />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="flex flex-col space-y-2">
                            <Label for="description_nl">Description (NL)</Label>
                            <Textarea id="description_nl" v-model="form.description_nl" placeholder="Project description" class="resize-none" />
                            <InputError :message="form.errors.description_nl" />
                        </div>
                        <div class="flex flex-col space-y-2">
                            <Label for="description_en">Description (EN)</Label>
                            <Textarea id="description_en" v-model="form.description_en" placeholder="Project description" class="resize-none" />
                            <InputError :message="form.errors.description_en" />
                        </div>
                        <div class="flex flex-col space-y-2">
                            <Label for="image">Image</Label>
                            <Input id="image" v-model="form.image" type="file" placeholder="Project image" />
                            <InputError :message="form.errors.image" />
                        </div>
                        <div class="flex flex-col space-y-2">
                            <Label for="url">URL</Label>
                            <Input id="url" v-model="form.url" type="text" placeholder="Project URL" />
                            <InputError :message="form.errors.url" />
                        </div>
                        <div class="flex flex-col space-y-2">
                            <Label for="github_url">GitHub URL</Label>
                            <Input id="github_url" v-model="form.github_url" type="text"
                                placeholder="Project GitHub URL" />
                            <InputError :message="form.errors.github_url" />
                        </div>
                    </div>

                    <Button type="submit">Submit</Button>
                </form>
            </DialogHeader>
        </DialogContent>
    </Dialog>
</template>