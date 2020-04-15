<template>
    <div>
        Twoje wszystkie posty
        <div>
            Powiadomienia: {{message}}
        </div>
        <httploadercomposite :loading="loading">
            <post-acitons v-for="(post,index) in postList" :key="index"
                          @update="updateView"
                          :post-id="post.postdata.post_id"
                            :publish="post.postdata.post_published"
            />
            <div v-if="!postsExits">
              <h3> Nie masz żadnego postu</h3>
                <h4>Dodaj jakieś </h4>
            </div>
        </httploadercomposite>
    </div>
</template>
<script>
    import postAcitons from "./postdeep/postdeepacitons.vue";
    import {httploadercomposite} from "../httphelper/httploadercomposite";

    export default {
        name: "postcrud",
        data() {
            return {
                postList: [],
                loading: false,
                message: ''
            }
        },
        created() {
            this.updateView()
        },
        computed:{
          postsExits(){
              return Object.values(this.postList).length > 0;
          }
        },
        methods: {
            updateView(msg) {
                this.loadPosts();
                this.message = msg;
                setTimeout(()=>{

                })
            },
            async loadPosts() {
                this.loading = true;
                let data = await this.$postManage.FetchAllUserPosts({postId: this.$store.getters.getUserId})
                if (data.datasuccess) {
                    this.postList = data.multicontent
                }else{
                    this.postList = []
                }
                this.loading = false;
                console.log(data);
            }
        },
        components: {
            postAcitons, httploadercomposite
        },

    }
</script>

<style scoped>

</style>