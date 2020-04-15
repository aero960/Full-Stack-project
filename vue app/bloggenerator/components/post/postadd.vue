<template>
    <div>
        Dodawanie postów
        <httploadercomposite :loading="loading">
            <formAddPost v-model="formData" @submit="postSubmit"></formAddPost>
            <template v-slot:loadingMessage>
                <div>Trwa dodawanie postu</div>
            </template>
        </httploadercomposite>

    </div>
</template>
<script>
    import formAddPost from "../forms/formaddpost.vue";
    import router from "../routes/webroutes";
    import {httploadercomposite} from "../httphelper/httploadercomposite";

    export default {
        name: "postadd",
        data() {
            return {
                formData: {},
                loading: false
            }
        },
        methods: {
            async postSubmit() {
                this.loading = true;
                let data = await this.createPost();
                if (data.datasuccess) {
                    await this.connectCategory(data.content.postdata.post_id, this.formData.category);
                    await this.publishPost(data.content.postdata.post_id, +this.formData.publish);
                    router.push({name: 'ActivePost', params: {postId: data.content.post_id}}).catch(err => {
                    });
                }
                this.loading = false;

            },
            createPost() {
                return this.$postManage.CreatePost(this.formData);
            },
            publishPost(postId, status) {
                return this.$postManage.ChengePostStatus({postId: postId, publish: status})
            },
            connectCategory(postId, category) {
                return this.$postManage.ConnectCategoryPost({postId: postId, category: category})
            }
        },
        components: {
            formAddPost,httploadercomposite
        }
    }
</script>

<style scoped>

</style>