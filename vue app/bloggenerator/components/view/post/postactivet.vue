<template>
    <div>

            <loader-composite v-if="currentyPost" :loading="loading">
                <full-post-schema
                        :content="currentyPost.postdata.post_content"
                        :createdAt="currentyPost.postdata.post_published_at"
                        :title="currentyPost.postdata.post_title"
                        :postId="currentyPost.postdata.post_id"
                        :username="currentyPost.user.username"
                        :authorId="currentyPost.postdata.user_id"

                        :tags="currentyPost.tags"
                        :categories="currentyPost.category"

                        :comments="currentyPost.comment"

                />
            </loader-composite>
        <p v-if="!currentyPost" >{{message}}</p>
    </div>

</template>
<script>

    import profileView from "../../account/accountview.vue";
    import fullPostSchema from "../../post/postschemafull.vue";
    import {httploadercomposite} from "../../httphelper/httploadercomposite";
    import Vue from 'vue'
    export default {
        name: "activepost",
        data() {
            return {
                currentyPost: null,
                loading: false,
                message: ''
            }
        },
        beforeRouteUpdate(to, from, next) {
            if(this.$route.params !== this.currentyPost.postdata.post_id){
                this.getPost();
            }
            next();
        },
        methods: {
            async getPost() {
                this.loading = true;
                try {
                    let data = await this.$postManage.FetchSpecificPost({id: this.$route.params.postId});
                    if (data.datasuccess) {
                        this.currentyPost = data.content;

                    }

                    this.message = data.info;

                } catch (e) {
                    console.log("Problem z pobraniem postu")
                }

                this.loading = false;
            }
        },
        mounted() {
            this.getPost();

        },
        components: {
            loaderComposite: httploadercomposite, fullPostSchema, profileView,
        }
    }
</script>

<style scoped>

</style>