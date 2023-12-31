<script lang="ts" setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";

const props = defineProps({
    post: {
        type: Object,
        default: () => ({}),
    },
    errors: Object,
});

interface EditUser {
    id: number;
    name: string;
    image: null;
};

const form : EditUser = useForm({
    id: props.post.id,
    name: props.post.name,
    image: null,
});

const submit = () => {
    router.post(`/posts/${props.post.id}`, {
        _method: 'put',
        name: form.name,
        image: form.image,
    })
};
</script>

<template>
    <Head title="Post Edit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Post Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mb-6">
                                <label
                                    for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900"
                                    >Name</label
                                >
                                <input
                                    type="text"
                                    v-model="form.name"
                                    name="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <div
                                    v-if="props.errors.name"
                                    class="text-sm text-red-600"
                                >
                                    {{ props.errors.name }}
                                </div>
                            </div>
                            <div class="mb-6">
                                <label
                                    for="image"
                                    class="block mb-2 text-sm font-medium text-gray-900"
                                    >Image</label
                                >
                                <input
                                    type="file"
                                    name="image" @input="form.image = $event.target.files[0]"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                            </div>
                            <button
                                type="submit"
                                class="text-white bg-blue-700  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 "
                                :disabled="form.processing"
                                :class="{ 'opacity-25': form.processing }"
                            >
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>