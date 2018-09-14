<template>
    <div class="container">
        <div class="row justify-content-center">

                <div class="alert alert-primary flash-position" role="alert" v-show="show">
                    <strong>{{body}}</strong>
                </div>

        </div>
    </div>
</template>

<script>
    export default {
        props : ['message'],

        data(){
            return {
                body: this.message,
                show: false
            }
        },

        created(){
            if(this.message){
                this.flash(this.message);
            }

            window.events.$on('flash' , message=>{
               this.flash(message);
            });
        },
        methods:{
            flash(message){
                this.body = message;
                this.show=true;

                this.hide();
            },
            hide(){
                setTimeout(()=> {
                    this.show = false;
                },3000);
            }
        }
    };
</script>

<style>
    .flash-position{
        position: fixed;
        right: 25px;
        bottom: 35px;
    }

</style>
