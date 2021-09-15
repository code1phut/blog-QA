<template>
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align: center">Manager Tags</h6>
            <div style="display: flex; flex-direction: row-reverse; margin-top: 5px">
                <div><Button type="success" @click="addModal=true">Add New</Button></div>
                <div><Input search placeholder="Enter something..." style="width: 300px; margin-right: 10px;"/></div>
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
                            <td>{{ tag.name }}</td>
                            <td>{{ tag.created_at }}</td>
                            <td>{{ tag.updated_at }}</td>
                            <td>
                                <Button type="primary" @click="showEditTag(tag, index)">Edit</Button>
                                <Button type="error" @click="showDeletingModal(tag.id, index)">Delete</Button>
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
                <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{ isAdding ? "Adding.." : "Add Tag" }}</Button>
            </div>
        </Modal>
        <!--  End Modal Create  -->
        <!--  Modal Update  -->
        <Modal
            v-model="editModal"
            title="Update Tag"
            :mask-closable="false"
            :closable="false"
        >
            <div>
                <label>Tag Name</label>
                <Input v-model="editData.name" placeholder="Enter something..." />
            </div>
            <div slot="footer">
                <Button type="default" @click="editModal=false">Cancel</Button>
                <Button type="primary" @click="updateTag(editData)" :disabled="isAdding" :loading="isAdding">{{ isAdding ? "Updating.." : "Update Tag" }}</Button>
            </div>
        </Modal>
        <!--  End Modal Update  -->
        <!-- Modal Delete  -->
        <Modal
            v-model="showModalDelete"
            width="360"
        >
            <p slot="header" style="color:#f60;text-align:center">
                <icon type="ios-information-circle"></icon>
                <span>Delete confirmation</span>
            </p>
            <div style="text-align:center">
                <p>Are you want to delete this tag ?</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long @click="deleteTag" :isloading="isDeleting">{{ isDeleting ? "Deleting.." : "Delete" }}</Button>
            </div>
        </Modal>
        <!-- End Modal Delete  -->
    </div>
</template>
<script>
import Vue from "vue";

export default {
    data () {
        return {
            data: {
                name: "",
            },
            editData: {
                id: "",
                name: "",
            },
            tags: {},
            deleteItem: {},
            addModal: false,
            editModal: false,
            isAdding: false,
            isDeleting: false,
            showModalDelete: false,
            index: -1,
        }
    },

    async created() {
        this.tags = await this.getTags();
    },

    methods: {

        async getTags() {
            const response = await this.callApi('get', 'api/admin/app/get_tags');
            return response.data;
        },

        async addTag() {
            if (this.data.name.trim() == '') return this.error('The tag name field is required.');
                await this.callApi('post', 'api/admin/app/create_tag', this.data).then((response) => {
                    this.success('Tag has been added successfully!');
                    this.tags.unshift(response.data);
                    this.addModal = false;
                    this.data.name = "";
            }).catch((e) => {
                this.error();
            });
        },

        async updateTag(editData) {
            if (this.editData.name.trim() == '') return this.error('The tag name field is required.');

                await this.callApi('post', `api/admin/app/update_tag/${editData.id}`, this.editData).then((response) => {
                    this.tags[this.index].name = this.editData.name;
                    this.success('Tag has been update successfully!');
                    this.editModal = false;
            }).catch((e) => {
                this.error();
            });
        },

        async deleteTag() {
            await this.callApi('post', `api/admin/app/delete_tag/${this.deleteItem}`).then((res) => {
                this.success('Tag has been delete successfully!');
                this.tags.splice(this.index, 1);
                this.showModalDelete = false;
            }).catch((e) => {
                this.error();
            });
        },

        showEditTag(tag, index) {
            let obj = {
                id: tag.id,
                name: tag.name
            };

            this.editData = obj;
            this.editModal = true;
            this.index = index
        },

        showDeletingModal(tag, idx) {
            this.showModalDelete = true
            this.deleteItem = tag;
            this.index = idx;
        }
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

