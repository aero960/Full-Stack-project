import axios from 'axios';

const state = {
    todos: [
        {
            id: 1,
            title: "Todo One"
        },
        {
            id: 2,
            title: "Todo Two"
        },
        {
            id: 3,
            title: "Todo Two"
        },
        {
            id: 5,
            title: "Todo Two"
        }
    ],
    objects:{
        cos:"test"
    }
};


//przekazywanie funkcji do pobierania
const getters = {
    allTodos: (state) =>{
            console.log(state)
        return state.todos
    },
    objectGet: (state) =>state.objects.cos

};

const actions = {
    fetchTodos : ({commit}) => {
       commit('setToDo',{id:7,title:"OMG"})
    }
};

const mutations = {
    setToDo: (state,value)=>{
        state.todos.push(value)
    }

};


export default {
     getters,state, actions, mutations
}