<template>
    <div>
        <show-full-category/>
        <div class="dflex">
            <div class="postList">
                <h1>Tutaj będą posty</h1>
                <post-Schema  v-for="post in getAllPosts"
                :user="post.postdata.user_id"
                :content="post.postdata.post_content"
                :creationDate="post.postdata.post_create_at"
                :title="post.postdata.post_title"
                :tags="post.tags"
                :category="post.category"
                :comment="post.comment"
                :key="post.postdata.post_id"
                />

            </div>
            <div class="currentyPost">
                <h1>Przegladasz wlasnie</h1>
                <div v-if="$route.params.postId" >
                    <router-view name="ActivePost" ></router-view>
                </div>
                <p v-else>
                    Teraz nie przegladasz postu
                </p>

            </div>
        </div>
    </div>

</template>
<script>
    import postSchema from "../../post/postschema.vue";
    import showFullCategory from "../../category/showFullCategory.vue";
    import {PostManaging} from "../../../class/post/post";

    export default {
        name: "post",
        data(){
          return{
              currentyPage:0,
              category: false,
              user: false
          }
        },
        asyncComputed:{
                async getAllPosts(){
                  let data =  await PostManaging.FetchAllPosts();
                  console.log(data)
                  return data.multicontent;
                }
        },
        components: {
            postSchema,showFullCategory
        }
    }
</script>

<style scoped>

</style>