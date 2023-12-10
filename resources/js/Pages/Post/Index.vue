<template>
    <div class="max-w-screen-md w-full mx-auto">
        <div v-if="isAdmin" class="form-group mb-4 flex items-center justify-between mb-6 pb-6 border-b border-gray-400">
            <h1 style="color: blue">Посты</h1>
            <Link :href="route('posts.create')" class="inline-block bg-sky-600 px-3 py-2 text-white">Добавить</Link>
        </div>
        <div class="mb-6 pb-6 border-b border-gray-400" v-for="post in posts">
            <Link :href="route('posts.show', post.id)">
                <h1 class="pb-4 text-xl link-text">{{ post.title }}</h1>
            </Link>
            <div class="pb-4"> <img class="w-50 h-80 object-cover" :src="post.image" :alt="post.id"></div>
            <p class="pb-4" style="word-break: break-word;">{{ post.content }}</p>
            <div class="flex justify-between items-center mt-2">
                <p class="text-right text-sm text-slate-500">{{ post.date }}</p>
            </div>
            <div v-if="post.comments_count > 0" class="mt-4">
                <p class="pb-4 text-xl link-text" v-if="!isShowed" @click="getComments(post)">Показать
                    {{ post.comments_count }} комментарий</p>
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
                    <input v-model="commentsData[post.id]" class="w-96 border p-2 border-slate-300" type="text"
                           placeholder="Добавить комментарий">
                </div>
                <div class="mb-3" v-if="errors[post.id] && errors[post.id].body">
                    <p v-for="error in errors[post.id].body" class="text-sm mt-2 text-red-500">{{ error }}</p>
                </div>
                <div class="form-group mb-4">
                    <a @click.prevent="storeComment(post)" href="#"
                       class="inline-block bg-sky-600 px-3 py-2 text-white">Комментировать</a>
                </div>
            </div>
            <div v-if="isAdmin" class="form-group my-4 flex items-center">
                <Link :href="route('posts.edit', post.id)" class="inline-block bg-green-600 px-3 py-2 text-white">
                    Редактировать
                </Link>
                <Link as="button" method="delete" :href="route('posts.destroy', post.id)" class="inline-block bg-rose-600 px-3 py-2 text-white ml-2">
                    Удалить
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {Link} from "@inertiajs/vue3";
import axios from "axios"; // добавлен импорт

export default {
    name: "Index",

    props: ['posts', "isAdmin"],
    data() {
        return {
            commentsData: {},
            comments: [],
            errors: [],
            isShowed: false,
        }
    },

    components: {Link},

    methods: {


        storeComment(post) {
            axios.post(`/posts/${post.id}/comment`, {body: this.commentsData[post.id] || ""})
                .then(res => {
                    this.commentsData[post.id] = "";
                    this.comments.unshift(res.data.data)
                    post.comments_count++
                    this.isShowed = true
                })
                .catch(e => {
                    this.errors = { ...this.errors, [post.id]: e.response.data.errors };
                })
        },

        getComments(post) {
            axios.get(`/posts/${post.id}/comment`)
                .then(res => {
                    this.commentsData[post.id] = "";
                    this.comments = res.data.data
                    this.isShowed = true
                })
        },
    },

    layout: MainLayout
}
</script>

<style scoped>
.link-text {
    font-size: medium;
    transition: color 0.3s; /* добавлен переход для плавного изменения цвета */
    cursor: pointer;
}

.link-text:hover {
    color: blue; /* цвет при наведении */
}
</style>
