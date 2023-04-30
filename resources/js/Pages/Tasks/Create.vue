
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
})

</script>
<template>
    <AuthenticatedLayout>
        <div class="w-full flex justify-center">
            <div class="sm:w-full lg:w-10/12 shadow-md bg-white rounded border">
                <div class="w-full flex justify-center">
                    <h3 class="text-lg font-bold uppercase mt-5 mb-5">Insert Tast</h3>
                </div>

                <div class="w-full flex justify-center">
                    <div class="md:w-9/12  shadow-md rounded bg-white border">

                        <h4 class="flex justify-center mt-3 mb-5">Create Brand</h4>
                        <form class="flex justify-center mb-5" @submit.prevent="insert">
                            <div>
                                <div>
                                    <InputLabel for="name" value="Brand" />

                                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                                        autofocus />

                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <!-- <div>
                                    <InputLabel for="image" value="Brand" />

                                    <input id="image" type="file" @input="form.image = $event.target.files[0]" />

                                    <InputError class="mt-2" :message="form.errors.image" />



                                </div> -->

                                <!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress> -->

                                <!-- <div class="flex items-center justify-end mt-4">


                                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Save Brand
                                    </PrimaryButton>
                                </div> -->



                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>