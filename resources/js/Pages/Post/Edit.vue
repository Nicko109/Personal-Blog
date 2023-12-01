<template>
    <div class="w-96 mx-auto">
        <div class="form-group mb-4">
            <Link :href="route('notes.index')" class="inline-block bg-sky-600 px-3 py-2 text-white">Назад</Link>
        </div>
        <div class="mb-4">
            <div class=" mb-3">
                <input v-model="title" class="w-96 border p-2 border-slate-300" type="text" placeholder="Добавить наименование">
                <div v-if="errors.title" class="text-red-600 text-sm">{{ errors.title }}</div>
            </div>
            <div class="flex mb-3 items-center">
                <textarea v-model="content" class="w-96  border p-2 border-slate-300" placeholder="Добавить описание" cols="45" rows="10"></textarea>
            </div>
            <div v-if="errors.content" class="text-red-600 text-sm">{{ errors.content }}</div>
            <div class="mb-4">
                <label for="file"></label>
                <input @change="initFile" id="file" type="file">
                <div v-if="errors.image" class="text-red-600 text-sm">{{ errors.image }}</div>
                <div v-if="image" class="text-green-600 text-sm">
                    {{post.image}}
                </div>

            </div>

            <div class="form-group mb-4">
                <a @click.prevent="update" href="#" class="inline-block bg-green-600 px-3 py-2 text-white">Редактировать</a>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {router} from "@inertiajs/vue3";
import {Link} from "@inertiajs/vue3";

export default {
    name: "Edit",

    layout: MainLayout,

    components: {Link},

    props: ['post', 'errors'],

    data() {
        return {
            title: this.post.title,
            content: this.post.content,
            image: this.post.image,
        }
    },

    methods: {

        initFile(e) {
            this.image = e.target.files[0]
        },

        update() {
            let formData = new FormData();
            formData.append('title', this.title);
            formData.append('content', this.content);
            formData.append('image', this.image);
            formData.append('_method', 'PATCH')
            router.post(`/posts/${this.post.id}`,  formData,
                { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } })
        }
    }
}
</script>

