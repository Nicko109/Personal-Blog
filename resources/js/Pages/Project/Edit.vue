<template>
    <div class="max-w-screen-md w-full mx-auto">
        <div class="form-group mb-4">
            <Link :href="route('projects.index')" class="inline-block bg-sky-600 px-3 py-2 text-white">Назад</Link>
        </div>
      <div class=" mb-3">
        <input v-model="title" class="w-96 border p-2 border-slate-300" type="text" placeholder="Добавить наименование">
        <div v-if="errors.title" class="text-red-600 text-sm">{{ errors.title }}</div>
      </div>
        <div class="form-group mb-4">
            <a @click.prevent="update" href="#" class="inline-block bg-green-600 px-3 py-2 text-white">Редактировать</a>
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

    props: ['project', 'errors'],

    data() {
        return {
            title: this.project.title,
        }
    },

    methods: {
        update() {
            router.patch(`/projects/${this.project.id}`, {title: this.title})
        }
    }

}
</script>

<style scoped>

</style>
