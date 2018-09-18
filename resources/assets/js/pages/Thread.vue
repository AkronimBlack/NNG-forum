<script>
    import Replies from '../components/Replies.vue';
    import Subscribe from '../components/Subscribe.vue';

    export default {
        props: ['initialRepliesCount'],

        components: { Replies , Subscribe},

        data(){
            return {
                repliesCount: this.initialRepliesCount,
            }
        }
    }
</script>