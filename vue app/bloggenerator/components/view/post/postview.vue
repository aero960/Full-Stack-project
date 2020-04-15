<template>
    <div>

        <div class="dflex">

            <div class="postList">
                <h1>Tutaj będą posty</h1>

                <loader-composite :loading="loading">
                    <post-schema v-for="(post,index) in posts"
                                 :user="post.user"
                                 :postId="post.postdata.post_id"
                                 :content="post.postdata.post_content"
                                 :creationDate="post.postdata.post_create_at"
                                 :title="post.postdata.post_title"
                                 :public="post.postdata.post_published"

                                 :category="post.category"
                                 :tags="post.tags"
                                 :comment="post.comment"
                                 :key="index"
                                 @postSelect="scrollToActivePost"/>
                    <div v-if="!posts.length">{{message}}</div>
                </loader-composite>
                <loader-composite :loading="pagerLoading">
                    <page-selector v-show="maxPage > 0" :maxPage="maxPage" @changePage="loadPost"/>
                </loader-composite>

            </div>
            <template v-if="$route.params.postId">
                <div class="currentyPost" style="position: -webkit-sticky; position: sticky; top: 20px;">
                    <h1 ref="scroll">Przegladasz wlasnie</h1>
                    <div>
                        <router-view name="ActivePost"></router-view>
                    </div>

                </div>
            </template>
        </div>
    </div>

</template>
<script>
    import postSchema from "../../post/postschemapost.vue";
    import showFullCategory from "../../category/categoryfullshow.vue";
    import pageSelector from "../../loadingmanage/loadingpageselector.vue";
    import DomHelper from "../../../class/domHelper";
    import {httploadercomposite} from "../../httphelper/httploadercomposite";

    export default {
        name: "post",
        data() {
            return {
                currentyPage: 0,
                maxPage: 0,
                posts: [],
                user: false,
                loading: false,
                pagerLoading: true,
                message: {}

            }
        },
        beforeRouteUpdate(to, from, next) {
            next();
            if (to.query['category'] !== from.query['category']) {
                this.loadPost(0);
            }
        },
        props: {
            name: {
                type: String,
                default: 'Vue!'
            }
        },
        methods: {
            scrollToActivePost() {
                DomHelper.smoothScroll(0, 250);
            },
            async loadPost(page) {
                this.loading = true;

                this.scrollToActivePost();
                this.currentyPage = page;
                let data;
                if (this.$route.query.hasOwnProperty('category')) {
                    data = await this.$postManage.FetchPostByCategory({categoryName: this.$route.query.category});
                } else
                    data = await this.$postManage.FetchAllPosts({page: this.currentyPage});

                if (data.datasuccess) {
                    this.posts = Object.values(data.multicontent);
                }
                this.maxPage = data.content?.maxpage ?? 0;
                this.pagerLoading = false;
                this.message = data.info;
                try {
                } catch (e) {
                    console.error("Problem ze wczytaniem postów");
                }
                this.loading = false;
            },
        },
        created() {
            this.loadPost(0);
        },
        components: {
            postSchema,
            pageSelector,
            showFullCategory,
            loaderComposite: httploadercomposite
        }
    }
</script>

<style scoped>

</style>