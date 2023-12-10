<template>
    <div class="max-w-screen-md w-full mx-auto">
        <div v-if="isAdmin" class="form-group mb-4 flex items-center justify-between mb-6 pb-6 border-b border-gray-400">
            <h1 style="color: blue">Проекты</h1>
            <Link :href="route('projects.create')" class="inline-block bg-sky-600 px-3 py-2 text-white">Добавить</Link>
        </div>
        <div class="mb-6 pb-6 border-b border-gray-400" v-for="project in projects" :key="project.id">
            <Link :href="route('projects.show', project.id)">
                <h1 style="word-break: break-word;" class="pb-4 text-xl link-text">{{ project.title }}</h1>
            </Link>
            <p class="pb-4">{{ project.content }}</p>
            <div class="flex justify-between items-center mt-2">
                <p class="text-right text-sm text-slate-500">{{ project.date }}</p>
            </div>
            <div v-if="project.comments_count > 0" class="mt-4">
                <p class="pb-4 text-xl link-text" v-if="!isShowed" @click="getComments(project)">
                    Показать {{ project.comments_count }} комментарий
                </p>
                <p class="pb-4 text-xl link-text" v-if="isShowed" @click="isShowed = false">Закрыть</p>
                <div v-if="comments && isShowed">
                    <div v-for="comment in comments" class="mt-4 pt-4 border-t border-gray-300">
                        <p class="text-sm">{{ comment.user.name }}</p>
                        <p style="word-break: break-word;">{{ comment.body }}</p>
                        <p class="text-right text-sm text-slate-500">{{ comment.date }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class=" mb-3">
                    <input v-model="commentsData[project.id]" class="w-96 border p-2 border-slate-300" type="text"
                           placeholder="Добавить комментарий">
                </div>
                <div class="mb-3" v-if="errors[project.id] && errors[project.id].body">
                    <p v-for="error in errors[project.id].body" class="text-sm mt-2 text-red-500">{{ error }}</p>
                </div>
                <div class="form-group mb-4">
                    <a @click.prevent="storeComment(project)" href="#"
                       class="inline-block bg-sky-600 px-3 py-2 text-white">
                        Комментировать
                    </a>
                </div>
            </div>
            <div v-if="isAdmin" class="form-group my-4 flex items-center">
                <Link :href="route('projects.edit', project.id)" class="inline-block bg-green-600 px-3 py-2 text-white">
                    Редактировать
                </Link>
                <Link as="button" method="delete" :href="route('projects.destroy', project.id)" class="inline-block bg-rose-600 px-3 py-2 text-white ml-2">
                    Удалить
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default {
    name: "Index",

    props: ["projects", "isAdmin"],
    data() {
        return {
            commentsData: {},
            comments: [],
            isShowed: false,
            errors: {},
        };
    },

    components: {Link},

    methods: {
        storeComment(project) {
            axios
                .post(`/projects/${project.id}/comment`, {body: this.commentsData[project.id] || ""})
                .then((res) => {
                    this.commentsData[project.id] = "";
                    this.comments.unshift(res.data.data);
                    project.comments_count++;
                    this.isShowed = true;
                })
                .catch(e => {
                    this.errors = { ...this.errors, [project.id]: e.response.data.errors };
                })
        },

        getComments(project) {
            axios
                .get(`/projects/${project.id}/comment`)
                .then((res) => {
                    this.commentsData[project.id] = "";
                    this.comments = res.data.data;
                    this.isShowed = true;
                })
        },
    },

    layout: MainLayout,
};
</script>

<style scoped>
.link-text {
    font-size: medium;
    transition: color 0.3s;
    cursor: pointer;
}

.link-text:hover {
    color: blue;
}
</style>
