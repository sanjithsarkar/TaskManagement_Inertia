<script setup>
import { router, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
    users: Object,
    statuses: Object,
    task: Object,
    comments: Object,
})

// console.log(props.users);
// const taskData = ref(props.task);

const form = useForm({
    assign_to: props.task?.assign_to,
    title: props.task?.title,
    description: props.task?.description,
    file: '',
    status_id: props.task?.status_id,
    deadline: props.task?.deadline,
    comment: '',
})


function updateTask() {
    console.log(form.data())

    router.post(
        route('tasks.update', { task: props.task?.id }),
        {
            _method: 'put',
            ...form.data()

        },{
            onSuccess: () => {
                // Clear the input after successful form submission
                document.getElementById('comment').value = '';
            },
        })
}


const timestamp = props.task.created_at;
const date = new Date(timestamp);

const day = ("0" + date.getUTCDate()).slice(-2);
const month = ("0" + (date.getUTCMonth() + 1)).slice(-2);
const year = date.getUTCFullYear();

const formattedDate = `${day}-${month}-${year}`;



</script>

<template>
    <div class="flex justify-center">
        <div class="w-8/12 h-screen shadow bg-gray-100 rounded">
            <div>
                <div class="my-9">
                    <Link :href="route('tasks.index')"
                        class="ml-16 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-6 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Back to Index
                    </Link>
                    <h3 class="ml-64 inline text-2xl font-extrabold font-serif h-16 items-center"> Update Task</h3>
                </div>

                <div v-if="$page.props.flash.message"
                    class="fixed top-24 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-10 w-72 flex justify-center items-center bg-green-600 text-white rounded-md shadow-lg">
                    {{ $page.props.flash.message }}
                </div>

                <form class="mb-5" @submit.prevent="updateTask">
                    <div class="grid grid-cols-5 gap-4">
                        <div class="col-span-3 mx-16 h-24 my-5">
                            <div>

                                <div class="my-3">
                                    Assign By: <span>{{ task.assign_by.name }} {{ formattedDate }}</span>
                                </div>

                                <div class="mb-3">

                                    Assign To: {{ task.assign_to.name }}

                                    <!-- <InputLabel for="assign_to" value="Assign To" /> -->

                                    <!-- <select id="assign_to" v-model="form.assign_to" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500
                                         rounded-md shadow-sm mt-1 block w-full mb-2">
                                        <option SELECTED>{{ task.assign_to.name }}</option>
                                        <option v-for="user in props.users" :key="user.id" :value="user.id">{{ user.name }}
                                        </option>
                                    </select> -->


                                    <InputError class="mt-2" :message="form.errors.assign_to" />
                                </div>

                                <div>
                                    <InputLabel for="title" value="Title" />
                                    <input id="title" type="text" class="mt-1 block w-full mb-2" v-model="form.title"
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
                                    <select v-model="form.status_id" id="status_id"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full mb-2">
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

                                    <img v-if="task.file != ''" class="w-20 h-20 rounded shadow"
                                        :src="route('home') + '/storage/' + task.file" alt="Null">
                                    <span v-else>No Image</span>
                                </div>

                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>

                                <div class="flex items-center justify-end mt-4">
                                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Update Task
                                    </PrimaryButton>
                                </div>
                            </div>

                        </div>

                        <div class="col-span-2 h-24 my-5">
                            <div>
                                <div class="mr-10">
                                    <InputLabel for="Comment" value="Comment" />
                                    <div
                                        class="rounded w-full h-40 overflow-y-scroll scrollbar-thumb-blue-500 bg-green-300">
                                        <div v-for="comment in comments" :key="comment.id" :value="comment.id">
                                            <span class="block mx-4 my-4">{{ comment.user.name }}:{{ comment.comment
                                            }}</span>
                                        </div>
                                    </div>

                                </div>

                                <div class="mr-10 mt-3">
                                    <InputLabel for="Comment" value="New Comment" />
                                    <TextInput id="comment" type="text" class="mt-1 block w-full mb-2"
                                        v-model="form.comment" autofocus />
                                    <InputError class="mt-2" :message="form.errors.description" />
                                </div>

                                <div class="mr-10">
                                    <InputLabel for="Deadline" value="Deadline" />
                                    <TextInput id="deadline" type="date" class="mt-1 block w-full" v-model="form.deadline"
                                        required autofocus />
                                    <InputError class="mt-2" :message="form.errors.deadline" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>



        </div>
    </div>
</template>