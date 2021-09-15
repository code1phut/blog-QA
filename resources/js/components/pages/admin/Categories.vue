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
                            <th style="width: 150px">Image</th>
                            <th>Create_At</th>
                            <th>Updated_At</th>
                            <th style="width: 250px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(category, index) in categories" :key="index" v-if="categories.length">
                            <td>{{ category.id }}</td>
                            <td>{{ category.name }}</td>
                            <td class="table_image">
                                <img style="width: 150px" :src="category.icon_image" />
                            </td>
                            <td>{{ category.created_at }}</td>
                            <td>{{ category.updated_at }}</td>
                            <td>
                                <Button type="primary" @click="showEditCategory(category, index)">Edit</Button>
                                <Button type="error" @click="showDeletingModal(category.id, index)">Delete</Button>
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
            <Input v-model="data.name" placeholder="Enter something..." />
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
            <div class="demo-upload-list" v-if="data.icon_image">
                <img :src="`${data.icon_image}`">
                <div class="demo-upload-list-cover">
                    <Icon type="ios-trash-outline" @click="deleteImage"/>
                </div>
            </div>
            <div slot="footer">
                <Button type="default" @click="addModal=false">Cancel</Button>
                <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{ isAdding ? "Adding.." : "Add Category" }}</Button>
            </div>
        </Modal>
        <!--  End Modal Create  -->
        <!--  Modal Update  -->
        <Modal
            v-model="editModal"
            title="Update Category"
            :mask-closable="false"
            :closable="false"
        >
            <div>
                <label>Name</label>
                <Input v-model="editData.name" placeholder="Enter something..." />
                <label>Image</label>
                <Upload
                    v-show="isIconImageNew"
                    ref="editDataUploads"
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
                <div class="demo-upload-list" v-if="editData.icon_image">
                    <img :src="`/${editData.icon_image}`">
                    <div class="demo-upload-list-cover">
                        <Icon type="ios-trash-outline" @click="deleteImage((false))"/>
                    </div>
                </div>
            </div>
            <div slot="footer">
                <Button type="default" @click="closeEditModal">Cancel</Button>
                <Button type="primary" @click="updateCategory(editData)" :disabled="isAdding" :loading="isAdding">{{ isAdding ? "Updating.." : "Update Tag" }}</Button>
            </div>
        </Modal>
        <!--  End Modal Update  -->
        <DeleteModal></DeleteModal>
    </div>
</template>
<script>
import Vue from "vue";
import DeleteModal from './components/DeleteModal.vue';
import {mapGetters} from "vuex";

export default {
    data () {
        return {
            data: {
                name: "",
                icon_image: "",
            },
            editData: {
                id: "",
                name: "",
                icon_image: "",
            },
            categories: {},
            deleteItem: {},
            addModal: false,
            editModal: false,
            isAdding: false,
            isDeleting: false,
            showModalDelete: false,
            index: -1,
            isIconImageNew: false,
            isEditingItem: false,
        }
    },

    async created() {
        this.categories = await this.getCategories();
    },

    components: {
        DeleteModal
    },

    computed: {
        ...mapGetters(['getDeleteModalBased'])
    },

    watch: {
        getDeleteModalBased(data) {
            if (data.isDeleted) {
                this.categories.splice(data.deletingIndex, 1);
            }
        }
    },

    methods: {

        async getCategories() {
            const response = await this.callApi('get', 'api/admin/app/get_categories');
            return response.data;
        },

        async addCategory() {
            if (this.data.name.trim() == '') return this.error('The name field is required.');
            if (this.data.icon_image.trim() == '') return this.error('The image field is required.');
            this.data.icon_image = `/uploads/images/${this.data.icon_image}`
            await this.callApi('post', 'api/admin/app/create_categories', this.data).then((response) => {
                this.success('Category has been added successfully!');
                this.categories.unshift(response.data);
                this.addModal = false;
                this.data.name = "";
                this.data.icon_image = "";
            }).catch((e) => {
                this.error();
            });
        },

        async updateCategory(editData) {
            if (this.editData.name.trim() == '') return this.error('The name field is required.');
            if (this.editData.icon_image.trim() == '') return this.error('The image field is required.');
            await this.callApi('post', `api/admin/app/update_category/${editData.id}`, this.editData).then((response) => {
                this.categories[this.index].name = this.editData.name;
                this.categories[this.index].icon_image = this.editData.icon_image;
                this.success('Category has been update successfully!');
                this.editModal = false;
            }).catch((e) => {
                this.error();
            });
        },

        showEditCategory(category, index) {
            let obj = {
                id: category.id,
                name: category.name,
                icon_image: category.icon_image
            };

            this.editData = obj;
            this.editModal = true;
            this.index = index
            this.isEditingItem = true;
        },

        showDeletingModal(category, idx) {
            const deleteModalBased = {
                showModalDelete: true,
                deleteUrl: `api/admin/app/delete_category/${category}`,
                deletingIndex: idx,
                isDeleted: false
            };
            this.$store.commit('setDeleteModal', deleteModalBased)
        },

        handleSuccess (res, file) {
            if (this.isEditingItem) {
                return this.editData.icon_image = `uploads/images/${res}`;
            }
            return this.data.icon_image = res;
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

        async deleteImage(isAdding = true) {
            let image;

            if (!isAdding) {
                // for editing category
                this.isIconImageNew = true
                image = this.editData.icon_image;
                this.editData.icon_image = '';
                this.$refs.editDataUploads.clearFiles();
            } else {
                image = this.data.icon_image;
                this.data.icon_image = '';
                this.$refs.uploads.clearFiles();
            }
            const res = await this.callApi('post', 'api/admin/app/delete_image', {image: image});
            if (res.status !== 200) {
                this.data.icon_image = image;
                this.swr();
            }
        },
        closeEditModal() {
            this.isEditingItem = false;
            this.editModal = false;
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

