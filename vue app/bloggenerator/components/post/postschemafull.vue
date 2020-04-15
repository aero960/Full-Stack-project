<template>
    <div>
        <h4>
            <div v-if="Object.values(categories).length">
                Cat:
                <span v-for="index in categories">{{index.category_title}}</span>
            </div>
        </h4>
        <br/>

        <div>
            <h1>{{title}}</h1>
            <p>
               By: <router-link :to="{name:'ActiveUser',params:{userId:authorId}}">{{username}}</router-link>
            </p>
            <p>{{content}}</p>
            <p>Created at: {{createdAt}}</p>
        </div>


        <br/>
        <p>Tags:</p>
        <div class="dflex"><p v-for="index in tags"
                              style="background-color: #2d72ff;
         border-radius: 5px;
         margin:10px 0px;
         max-width: 200px;
         font-size:15px;
         text-align: center;
         font-weight: bold;
         text-transform: uppercase;
        padding:3px;">
            {{index.tag_title}}</p></div>
        <br/>
        <div>
            <p>Komentarze</p>
            <comment-schema v-for="comment in getCommentList"
                            :title="comment.commentdata.comment_title"
                            :content="comment.commentdata.comment_content"
                            :id="comment.commentdata.comment_id"
                            :authorId="comment.userdata.id"
                            :username="comment.userdata.username"
                            :create-date="comment.commentdata.comment_created_at"
                            :key="comment.commentdata.comment_id"

            />

            <div v-if="!commentList.length">
                Brak komentarzy dodaj cos od siebie
            </div>


            <div>
                <button @click="switchAddCommentSection">Add comment</button>
                <addcommentform v-if="prepareToAddButton" ref="commentForm" v-model="formData" @submit="addComment"/>
                <button @click="showMoreComment">Pokaż wszystkie posty</button>
            </div>


        </div>
    </div>
</template>

<script>
    import addcommentform from "../forms/formsaddcomment.vue";
    import {CommentManaging} from "../../class/post/comment";
    import DomHelper from "../../class/domHelper";
    import commentSchema from './postschemacomment.vue';

    export default {
        name: "fullpostSchema",
        data() {
            return {
                prepareToAddButton: false,
                formData: {},
                commentList: Object.values(this.comments),
                commentShortForm: true
            }
        },
        methods: {
            async addComment() {
                this.addSynteticPost(this.formData.username, this.formData.title, this.formData.content);
                this.switchAddCommentSection();

                await CommentManaging.createComment({
                        post: this.postId,
                        username: this.formData.username,
                        title: this.formData.title,
                        content: this.formData.content
                    }
                );
            },
            switchAddCommentSection() {
                new Promise((res) => {
                    this.prepareToAddButton = !this.prepareToAddButton;
                    res(this.prepareToAddButton);
                }).then(
                    (res) => {
                        if (res) {
                            let element = this.$refs.commentForm.$el;
                            DomHelper.smoothScroll(element.offsetTop - 500, 200)
                        }
                    }
                )
            },
            switchShortCommentSection() {
                if (!this.commentShortForm) {
                    DomHelper.smoothScroll(0, 300);
                }
            },
            showMoreComment() {
                this.switchShortCommentSection();
                return this.getCommentList = !this.commentShortForm;

            },
            addSynteticPost(username, title, content) {
                this.commentList.push({
                    commentdata: {
                        comment_title: title,
                        comment_content: content,
                        comment_created_at: new Date().toJSON().slice(0, 10)
                    },
                    userdata: {
                        username: username
                    }

                })
            }
        },
        computed: {
            getCommentList: {
                get: function () {
                    let data = [...this.commentList];
                    if (this.commentShortForm)
                        data.splice(3, this.commentList.length)
                    return data;
                },
                set: function (value) {

                    this.commentShortForm = value
                }
            },

        },
        props: {
            content: {
                type: String,
                required: true
            },
            createdAt: {},
            comments: {},
            categories: {},
            tags: {},
            title: {},
            postId: {},
            authorId:{},
            username: {}
        },
        components: {
            addcommentform, commentSchema
        }
    }
</script>

<style scoped>

</style>