<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-10">
                    <h4><a :href="'/profiles/' + data.owner.name" v-text="data.owner.name"></a></h4>
                    said {{data.created_at}}
                </div>
                <div class="col-2 text-right" v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <textarea rows="3" class="form-control" v-model="body"></textarea>
                <button class="btn btn-primary" @click="update">Edit</button>
                <button class="btn btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body">
            </div>
        </div>
        <!--@can ('update' , $reply)-->
        <div class="card-footer"  v-if="canUpdate">
            <div class="row">
                <div class="col-md-12 level">
                    <button class="btn btn-primary" @click="editing = true">Edit</button>
                    <button class="btn btn-primary" @click="destroy">Delete</button>
                </div>
            </div>
        </div>
        <!--@endcan-->
    </div>


</template>

<script>
    import Favorite from './Favorite.vue';

    export default {
        props: ['data'],

        components: {Favorite},

        data() {
            return {
                editing: false,
                body: this.data.body,
                id: this.data.id
            };
        },

        computed :{
               signedIn(){
                   return window.App.signedIn;
               },
            canUpdate(){
                   // bootstrap.js
                   return this.authorize(user => this.data.owner.id == user.id);
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                });

                this.editing = false;

                flash('You have updated a reply');
            },
            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted' , this.data.id);

                // $(this.$el).fadeOut(300, () => {
                //     flash('Reply deleted');
                // });


            }
        }
    }
</script>