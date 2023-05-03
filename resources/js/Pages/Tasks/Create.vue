
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link } from '@inertiajs/vue3'
import { ref } from "vue";
const form = useForm({
    assign_to: '',
    title: '',
    description: '',
    file: '',
    status_id: '',
    deadline: ''

})

const props = defineProps({
    users: Object,
    statuses: Object,

})

// const usersList = ref(props.users);

// const statusList = ref(props.statuses);

function insert() {
    form.post(route('tasks.store'), {
        forceFormData: true
    })
}

</script>
<template>
    <AuthenticatedLayout>
        <div class="w-full flex justify-center">
            <div class="sm:w-full lg:w-10/12 shadow-md bg-white rounded border">
                <div class="w-full flex justify-center">
                    <h3 class="text-lg font-bold uppercase mt-5 mb-5">Insert Tast</h3>
                </div>
                <!-- {{ props.usersList }} -->
                <div class="w-full flex justify-center">
                    <div class="">
                        <form class="flex justify-center mb-5" @submit.prevent="insert">
                            <div>
                                <div>
                                    <InputLabel for="assign_to" value="Assign To" />
                                    <select v-model="form.assign_to" id="assign_to" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full mb-2">
                                        <option selected disabled>Choose a User</option>
                                        <option v-for="user in props.users" :key="user.id" :value="user.id">{{ user.name }}
                                        </option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.assign_to" />
                                </div>

                                <div>
                                    <InputLabel for="title" value="Title" />
                                    <TextInput id="title" type="text" class="mt-1 block w-full mb-2" v-model="form.title"
                                        required autofocus />
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>

                                <div>
                                    <InputLabel for="description" value="Description" />
                                    <TextInput id="description" type="text" class="mt-1 block w-full mb-2"
                                        v-model="form.description" required autofocus />
                                    <InputError class="mt-2" :message="form.errors.description" />
                                </div>

                                <div>
                                    <InputLabel for="Status" value="Status" />
                                    <select v-model="form.status_id" id="status_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full mb-2">
                                        <option selected disabled>Choose a Status</option>
                                        <option v-for="status in statuses" :key="status.id" :value="status.id">{{
                                            status.status }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.status_id" />
                                </div>

                                <div>
                                    <InputLabel for="file" value="File" />
                                    <input id="file" type="file" class="mb-2" @input="form.file = $event.target.files[0]" />
                                    <InputError class="mt-2" :message="form.errors.file" />
                                </div>

                                <div>
                                    <InputLabel for="Deadline" value="Deadline" />
                                    <TextInput id="deadline" type="date" class="mt-1 block w-full" v-model="form.deadline"
                                        required autofocus />
                                    <InputError class="mt-2" :message="form.errors.deadline" />
                                </div>

                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>

                                <div class="flex items-center justify-end mt-4">
                                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Save Task
                                    </PrimaryButton>

                                    <Link :href="route('tasks.index')"
                                        class="ml-28 mt-6 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-6 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    Back to Index
                                    </Link>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>