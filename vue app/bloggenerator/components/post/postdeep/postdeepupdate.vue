<template>
    <div>
        <httploadercomposite :loading="loading">
            <formsupdatepost v-model="formData"  @submit="submit" :postId="$route.params.postIdToUpdate"></formsupdatepost>
            <template v-slot:loadingMessage v-if="!loading">
                Aktualizowanie postu
            </template>
        </httploadercomposite>
    </div>
</template>
<script>
    import formsupdatepost from "../../forms/formsupdatepost.vue";
    import {httploadercomposite} from "../../httphelper/httploadercomposite";

    export default {
        name: "postdeepupdate",
        data(){
          return{
              formData: {},
              loading: false
          }
        },
        components:{
             formsupdatepost,httploadercomposite
        },
        methods:{
          async  submit(){
                this.loading = true;
                let data = await this.$postManage.UpdatePost({postId:this.$route.params.postIdToUpdate,title: this.formData.title,content:this.formData.content,tags:this.formData.tags})
              console.log(data)
                if(data.datasuccess){
                        await this.$postManage.ConnectCategoryPost({postId: this.$route.params.postIdToUpdate,category:Object.values(this.formData.category)})
                }
              this.loading = false;
            },
        }
    }
</script>

<style scoped>

</style>