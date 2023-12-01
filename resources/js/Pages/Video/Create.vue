    <template>
        <div class="max-w-screen-md w-full mx-auto">
            <div class="form-group mb-4">
                <Link :href="route('videos.index')" class="inline-block bg-sky-600 px-3 py-2 text-white">Назад</Link>
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
                    <div v-if="errors.file" class="text-red-600 text-sm">{{ errors.file }}</div>
                </div>

                <div class="form-group mb-4">
                    <a @click.prevent="store" href="#" class="inline-block bg-sky-600 px-3 py-2 text-white">Добавить</a>
                </div>
            </div>
        </div>
    </template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {router} from "@inertiajs/vue3";
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default {
    name: "Create",

    layout: MainLayout,

    components: {Link},


    props: [
        'errors'
    ],

    data() {
        return {
            title: '',
            content: '',
            file: null,
        }
    },

    methods: {

        initFile(e) {
            this.file = new FormData()
            this.file.append('file', e.target.files[0])
        },

        store() {
            this.file.append('title',  this.title);
            this.file.append('content',  this.content);  // добавил эту строку, чтобы передать контент
            router.post('/videos', this.file)
        }
    }
}

</script>


