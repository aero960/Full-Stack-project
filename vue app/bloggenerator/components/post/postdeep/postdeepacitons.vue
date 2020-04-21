<template>
    <div :class="{dflex: true,notPublic: !publish}" >
        <button style="background-color: #e1b73c" @click="geToShow">Sprawdź post</button>
        <button style="background-color: #48ac2e" @click="goToUpdate">Aktualizuj</button>
        <div>
            <button style="background-color: #2d72ff" v-if="!publish" @click="publishPost(1)">Opublikuj</button>
            <button style="background-color: #2d72ff" v-if="publish" @click="publishPost(0)">zachowaj post dla siebie
            </button>
        </div>
        <button-sure @click="deletePost" :question="'Czy na pewno chcesz usunąć post?'" :placeholder="'delete'">Delete
        </button-sure>
        <div>
         Id:   {{postId}}
         Tytuł:  {{title}}
         Data stworzenia:   {{creationDate}}
         Data aktualizacji:   {{updatedTime}}
        </div>
    </div>
</template>
<script>
    import {ButtonSure} from "../../forms/forms";

    export default {
        name: "postacitons",
        data() {
            return {
                message: 'rqwrqwr',
                loading: false,
            }
        },
        props: {
            postId: {
                type: String,
                required: true
            },
            publish: {
                type: Boolean,
                required: true
            },
            title:{type:String},
            updatedTime:{type:String},
            creationDate:{type:String}
        },
        methods: {
            goToUpdate() {
                if (this.$route.name !== 'UpdatePost')
                    this.$router.replace({name: 'UpdatePost', params: {postIdToUpdate: this.postId}}).catch();
            },
            geToShow() {
                if (this.$route.name !== 'PostShow')
                    this.$router.replace({name: 'PostShow', params: {postId: this.postId}}).catch();
            },
            async publishPost(status) {
                let data = await this.$postManage.ChengePostStatus({postId: this.postId, publish: status});
                if (data.datasuccess) {
                    this.message = data.info
                }
                this.updateView();
            },
            async deletePost(k) {
                let data = await this.$postManage.DeletePost({postId: this.postId});
                if (data.datasuccess) {
                    this.message = data.info;
                } else {
                    this.message = "Nie można usunąć postu"
                }
                this.updateView();
            },
            updateView() {
                this.$emit('update', this.message);
            },
        },
        components: {
            ButtonSure
        }

    }
</script>

<style scoped>

</style>