<template>
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align: center">Manager Category</h6>
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
            title="Add Category"
            :mask-closable="false"
            :closable="false"
        >
            <label>Name</label>
            <Input v-model="editData.name" placeholder="Enter something..." />
            <label>Image</label>
            <Upload
                ref="uploads"
                :headers="{'X-Requested-With': 'XMLHttpRequest'}"
                action="api/admin/app/upload"
                type="drag"
                :format="['jpg','jpeg','png']"
                :on-success="handleSuccess"
                :on-error="handleError"
                :on-format-error="handleFormatError"
                :on-exceeded-size="handleMaxSize"
                :max-size="2048"
            >
                <div style="padding: 20px 0">
                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                    <p>Click or drag files here to upload</p>
                </div>
            </Upload>
            <div class="demo-upload-list" v-if="data.image">
                <img :src="`/uploads/images/${data.image}`">
                <div class="demo-upload-list-cover">
                    <Icon type="ios-trash-outline" @click="deleteImage"/>
                </div>
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
                <Button type="primary" @click="updateTag(editData)" :disable="isAdding" :loading="isAdding">{{ isAdding ? "Updating.." : "Update Tag" }}</Button>
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
                image: "",
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
        },
        handleSuccess (res, file) {
            this.data.image = res;
        },
        handleError (res, file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: `${file.errors.file.length ? file.errors.file[0]: 'Something went wrong!'}`
            });
        },
        handleFormatError (file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleMaxSize (file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },
        async deleteImage() {
            let image = this.data.image;
            this.data.image = '';
            this.$refs.uploads.clearFiles();
            const res = await this.callApi('post', 'api/admin/app/delete_image', {image: image});
            if (res.status !== 200) {
                this.data.image = image;
                this.swr();
            }
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
.demo-upload-list{
    display: inline-block;
    width: 60px;
    height: 60px;
    text-align: center;
    line-height: 60px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0,0,0,.2);
    margin-right: 4px;
}
.demo-upload-list img{
    width: 100%;
    height: 100%;
}
.demo-upload-list-cover{
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,.6);
}
.demo-upload-list:hover .demo-upload-list-cover{
    display: block;
}
.demo-upload-list-cover i{
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
}
</style>

