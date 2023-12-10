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
            errors: {},
        };
    },

    components: {Link},



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
