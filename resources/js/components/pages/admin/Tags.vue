<template>
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align: center">Manager Tags</h6>
            <div>
                <Button type="success" @click="addModal=true">Add Tag</Button>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th scope="row">#</th>
                            <th style="width: 150px">Name</th>
                            <th>Create_At</th>
                            <th>Updated_At</th>
                            <th style="width: 250px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(tag, index) in tags" :key="index" v-if="tags.length">
                            <td>{{ tag.id }}</td>
                            <td><Tag color="cyan">{{ tag.name }}</Tag></td>
                            <td>{{ tag.created_at }}</td>
                            <td>{{ tag.updated_at }}</td>
                            <td>
                                <Button type="primary">View</Button>
                                <Button type="error">Delete</Button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--  Modal Create  -->
        <Modal
            v-model="addModal"
            title="Add Tag"
            :mask-closable="false"
            :closable="false"
        >
            <div>
                <label>Tag Name</label>
                <Input v-model="data.name" placeholder="Enter something..." />
            </div>
            <div slot="footer">
                <Button type="default" @click="addModal=false">Cancel</Button>
                <Button type="primary" @click="addTag" :disable="isAdding" :loading="isAdding">{{ isAdding ? "Adding.." : "Add Tag" }}</Button>
            </div>
        </Modal>
        <!--  End Modal Create  -->
    </div>
</template>
<script>
export default {
    data () {
        return {
            data : {
                name: "",
            },
            tags: {},
            addModal: false,
            isAdding: false,
        }
    },

    async created() {
        this.tags = await this.getTags();
    },

    methods: {

        async addTag() {
            if (this.data.name.trim() == '') return this.error('Tag Name is required!');
                await this.callApi('post', '/app/create_tag', this.data).then((response) => {
                    this.success('Tag has been added successfully!');
                    this.tags.unshift(response.data);
                    this.addModal = false;
                    this.data.name = "";
            }).catch((e) => {
                this.error();
            });
        },

        async getTags() {
          const response = await this.callApi('get', '/app/get_tags');
          return response.data;
        },
    }

}
</script>

<style lang="scss" scoped>
label {
    font-weight: bold;
}
.button-right {
    float: right;
}
</style>

