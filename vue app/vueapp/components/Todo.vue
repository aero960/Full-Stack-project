<template lang="pug">
       div
        div Todos
        .todos
            .todo(v-for="todo in allTodos" v-bind:key="todo.id" class="todo") {{todo.title}}
            .todo {{objectGet}}
            button(@click="fetchTodos") Dodaj to do

</template>

<script>

    import {mapGetters, mapActions} from "vuex"
    console.log(mapActions(['fetchTodos']));
    export default {
        name: "ToDo",
        methods:{
            ...mapActions(['fetchTodos'])
        },
        computed: mapGetters(['allTodos','objectGet']),
        created() {
            this.fetchTodos();
        }
    }
</script>

<style scoped>
        .todos{
            background: #a93da2;
        }
        .todo{
            border-bottom: 1px solid black;
            padding: 10px;
        }
</style>