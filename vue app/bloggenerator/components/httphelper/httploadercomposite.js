import loader from "./httploader.vue";
export const httploadercomposite  = ({
    template: `
        <div>
            <slot v-if="!loading"></slot>
            <loader v-if="loading"></loader>
            <slot name="loadingMessage"></slot>
        </div>
    `,
    props: {
        loading: {
            default: true,
           required: true}
    },
    watch: {
        'loading':()=> {}
    },
    components: {
        loader
    }
});