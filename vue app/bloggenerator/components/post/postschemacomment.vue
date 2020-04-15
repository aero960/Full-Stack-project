<template>
    <div style="margin:50px 0px;">

        <p>Title: {{title}}</p>
        <p>By
            <router-link :to="{name:'ActiveUser',params:{userId:authorId}}">{{username}}</router-link>
            : {{createDate}}
        </p>
        <p>{{content}}</p>

        <isloggedComposite :message="'Musisz być zalogowany by zgłosić post'">
            <template v-slot:logged>
                <button v-if="!reported" @click="switchReportForm">Zgłoś post</button>

                <report-form ref="reportForm" v-if="reportedClicked && !reported" @submit="reportPost"
                             v-model="formData"/>

                <div v-if="reported">{{message}}</div>
            </template>
            <template v-slot:notLogged>
                {{'Musisz się zalogować by zgłosić post'}}
            </template>

        </isloggedComposite>

    </div>
</template>

<script>
    import {CommentManaging} from "../../class/post/comment";
    import reportForm from "../forms/formreport.vue";
    import isloggedComposite from "../account/accountlogged.vue";
    import DomHelper from "../../class/domHelper";

    export default {
        name: "commentSchema",
        data() {
            return {
                reported: false,
                formData: {},
                reportedClicked: false,
                message: ''
            }
        },
        components: {
            reportForm, isloggedComposite
        },
        props: {
            title: {},
            id: {},
            username: {},
            createDate: {},
            content: {},
            authorId: {}
        },
        methods: {
            async reportPost() {
                try {
                    let data = await CommentManaging.reportPost({
                        commentId: this.id,
                        message: this.formData.message
                    });
                    if (data.datasuccess)
                        this.reported = true;
                    this.message = data.content.info
                } catch (e) {
                    console.error("Problem z wyslaniem zgłoszenia w schemacie komentarza");
                }
            },
            switchReportForm() {
                new Promise((res) => {
                    this.reportedClicked = !this.reportedClicked;
                    res(this.reportedClicked);
                }).then(
                    (res) => {
                        if (res) {
                            let element = this.$refs.reportForm.$el;
                            DomHelper.smoothScroll(element.offsetTop - 500, 500)
                        }
                    }
                )
            }


        }

    }
</script>

<style scoped>

</style>