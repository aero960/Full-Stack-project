<template>
    <div class="dflex">

        <button v-if="getCurrentyPage > 0" @click="selectPage(getCurrentyPage -1)">
            previous
        </button>

        <template v-if="!leftIntersect">
            <button @click="selectPage(0)">1</button>
            ...
        </template>

        <button v-for="numberPage in getComparatment()"
                :class=" (numberPage === getCurrentyPage) ? {selectedPage : true} : null"
                @click="selectPage(numberPage)"
        >
            {{numberPage + 1}}
        </button>

        <template v-if="!rightIntersect">
            ...
            <button @click="selectPage(maxPage)">{{maxPage + 1}}</button>
        </template>

        <button v-if="getCurrentyPage < maxPage" @click="selectPage(getCurrentyPage +1)">
            next
        </button>
    </div>
</template>

<script>
    export default {
        name: "pageselector",
        data() {
            return {
                currentyPage: 0,
                comparatment: 2,
                leftIntersect: false,
                rightIntersect: false
            }
        },
        methods: {
            limitCompartment(page) {
                if (page <= 0) {
                    return 0;
                }
                if (page >= this.maxPage) {
                    return this.maxPage;
                }
                return page;
            },
            checkIntersect() {
                if (this.getCurrentyPage <= 3) {
                    this.leftIntersect = true;
                } else {
                    this.leftIntersect = false;
                }
                if (this.getCurrentyPage >= this.maxPage - 4) {
                    this.rightIntersect = true;
                } else {
                    this.rightIntersect = false
                }
            },
            getComparatment() {
                let from = this.limitCompartment(this.getCurrentyPage - this.comparatment);
                let to = this.limitCompartment(this.getCurrentyPage + this.comparatment);

                this.checkIntersect();

                return Array.from({length: to - from + 1}, (index, value) => value + from)
            },
            selectPage(page) {
                if(page !== this.currentyPage){
                    this.currentyPage = page;
                    this.$emit('changePage', page);

                }

            }
        },
        computed: {
            getCurrentyPage() {
                return this.limitCompartment(this.currentyPage);
            }
        },
        created() {
            this.getComparatment();
        },
        props: {
            maxPage: {
                type: Number,
                default: 5
            }
        }
    }
</script>

<style scoped lang="scss">

    .selectedPage {
        font-family: 'Anton', sans-serif;
        color: #ffb224;
        font-size: 40px;

    }
</style>