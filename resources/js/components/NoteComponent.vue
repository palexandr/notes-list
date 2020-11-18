<template>
    <div class="note card">
        <div class="card-body">
            <h5 class="card-title">{{ title }}</h5>
            <p class="card-text">{{ note }}</p>
            <a v-bind:href="'/files/' + id" v-if="file">File</a>
            <div class="text-right">
                <button class="btn btn-primary btn-sm" v-on:click="del">Delete</button>  
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'title', 'note', 'file'],
        methods: {
            del() {
                this.$emit('delete', this.id);
            }
        }
    }
</script>

<style>
.note {
    margin-bottom: 10px;
}
</style>