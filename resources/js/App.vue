<template>
  <div id="app">
    <div class="heading clearfix">
        <h1>My notes</h1>
        
    </div>
    <div class="text-right">
        <button v-on:click="showModal" class="btn btn-primary">Add note</button>
    </div>
    <br>

    <b-modal ref="my-modal" hide-footer title="Add note">
        <form v-on:submit="create">
            <div class="form-group">
                <label for="form-title">Title *</label>
                <input type="input" class="form-control"  id="form-title" v-model="note.title" required>
            </div>
            <div class="form-group">
                <label for="form-text">Text *</label>
                <textarea class="form-control" rows=3 id="form-text" v-model="note.note" required></textarea>
            </div>
            <div class="form-group">
                <label for="form-file">File (optional)</label>
                <input type="file" class="form-control-file" ref="file" id="form-file" v-on:change="setFile">
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Create</button>
                <button type="button" class="btn btn-default" v-on:click="hideModal">Cancel</button>
            </div>
        </form>
    </b-modal>
    
    <note-component
      v-for="note in notes"
      v-bind="note"
      :key="note.id"
      v-on:delete="del"
    ></note-component>
    <b-pagination
      v-model="currentPage"
      :total-rows="rows"
      :per-page="perPage"
      v-if="rows > perPage"
    ></b-pagination>
  </div>
</template>

<script>
export default {
    data() {
        return {
            note: {},
            file: '',
            notes: [],
            rows: 1,
            perPage: 100,
            currentPage: 1
        }
    },
    watch: {
        currentPage: {
            handler: function(newPage) {
                this.loadPage(newPage);
            }
        }
    },
    methods: {
        showModal() {
            this.$refs['my-modal'].show()
        },
        hideModal() {
            this.$refs['my-modal'].hide()
        },
        loadPage(page) {
            this.axios
                .get('/api/v1/notes', { params: {
                    page: page
                }})
                .then(response => {
                    let data = response.data;
                    this.notes = [];
                    this.currentPage = data.current_page;
                    this.rows = data.total;
                    this.perPage = data.per_page;
                    for(let i in data.data) {
                        let note = data.data[i];
                        this.notes.push({
                            id: note.id,
                            title: note.title,
                            note: note.note,
                            file: note.file != null
                        });
                    }
                })
                .finally(() => {
                    this.note= {};
                }); 
        },
        setFile() {
            this.file = this.$refs.file.files[0];
        },
        create(e) {
            e.preventDefault();
            let formData = new FormData();
            formData.append('title', this.note.title);
            formData.append('note', this.note.note);
            formData.append('file', this.file);
            this.axios
                .post('/api/v1/notes', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    this.hideModal();
                    this.loadPage(1);
                })
                .catch(error => console.log(error));
        },
        del(id) {
            this.axios.delete(`/api/v1/notes/${id}`)
            .then((response) => {
                this.loadPage(1);
            })
        },
        
    },
    created() {
        this.loadPage(1);
    }
}
</script>

<style> 
#app {
    padding-top: 20px;
}
</style>