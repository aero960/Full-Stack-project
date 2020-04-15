<template>
    <div :class="{element:true,
                  notPublic:!public}">
        <h1 v-if="!public">Ten post jest prywatny</h1>
        <h3>
            <span v-if="!category.length" v-for="index in category"> {{index.category_title}} </span>
            <span v-else>post nie ma kategorii</span>
        </h3>

        <h1>{{title}}</h1>
        <h4>{{content | cutContent}}</h4>
        <h6>{{user.username}}</h6>
        <router-link :to="{name:'ActivePost',params:{postId},query:$route.query}"
                     v-on:click.native="$emit('postSelect')">Przejdz do postu
        </router-link>
        <div>
            Tags
            <p v-for="tag in tags" style="background-color: #2d72ff;
         border-radius: 5px;
         margin:10px 0px;
         max-width: 200px;
         font-size:15px;
         text-align: center;
         font-weight: bold;
         text-transform: uppercase;
        padding:3px;">
                {{tag.tag_title}}
            </p>
        </div>


        <p>Like</p>
    </div>
</template>

<script>
    import {PostManaging} from "../../class/post/post";
    import DomHelper from "../../class/domHelper";

    export default {
        name: "postSchema",
        data() {
            return {
                username: 'unknown',
                email: "unknown"
            }
        },
        props: {
            content: {
                type: String,
                required: true,
            },
            title: {
                type: String,
                required: true
            },
            user: {
                required: true
            },
            public:{
                type:Boolean,
                required: true
            },
            tags: {},
            postId: {},
            category: {
                default: []
            }
        },
        filters: {
            cutContent(content) {
                let percentOfContent = ((Math.random() * 5) + 25) / 100;
                return `${content.substr(0, Math.ceil(content.length * percentOfContent))}...`;
            }
        }
    }
</script>

<style scoped>

</style>