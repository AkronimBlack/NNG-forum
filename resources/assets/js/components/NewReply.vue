<template>

    <div v-if="signedIn">
        <div class="form-group">
            <textarea class="form-control" name="body" rows="6" placeholder="Express your opinion" required v-model="body"></textarea>
        </div>
            <button type="submit" class="btn btn-primary" @click="addReply">Reply</button>
    </div>
    <p class="text-center" v-else>Sign in to comment</p>

</template>

<script>
    export default {

        data(){
            return {
                body:'',
            }
        },

        computed : {
            signedIn(){
                return window.App.signedIn;
            }
        },

        methods : {
            addReply(){
                axios.post(location.pathname + '/replies' , {body: this.body})
                    .then(({data})=>{
                        this.body = '';

                        flash('Your reply has been posted');

                        this.$emit('created' , data)
                    });
            }
        }
    }
</script>