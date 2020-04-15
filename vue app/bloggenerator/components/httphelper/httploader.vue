<template>
    <div>
        DATA LOADING <span style="font-size: 78px">{{currentyLoader.render}}</span>
    </div>
</template>

<script>
    import Vue from 'vue'
    export default {
        name: "loader",
        data() {
            return {
                currentyLoader: {
                    count: 3,
                    render: "."
                },
            }
        },
        watch:{
            "currentyLoader.count": ()=>{}
        },
        mounted() {
            setInterval(() => {
               let number = (this.currentyLoader.count <= 3) ? this.currentyLoader.count + 1 : this.currentyLoader.count = 1
                Vue.set(this.currentyLoader,"render",".".repeat(this.currentyLoader.count));
                Vue.set(this.currentyLoader,'count', number);
            }, 75)
        }
    }
</script>

<style scoped>

</style>