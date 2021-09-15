<template>
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align: center">Manager Users</h6>
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
                            <th style="width: 150px">Username</th>
                            <th style="width: 150px">Full Name</th>
                            <th style="width: 150px">Email</th>
                            <th style="width: 150px">Role</th>
                            <th>Create_At</th>
                            <th>Updated_At</th>
                            <th style="width: 250px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(user, index) in users" :key="index" v-if="users.length">
                            <td>{{ user.id }}</td>
                            <td>{{ user.user_name }}</td>
                            <td>{{ user.full_name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.role }}</td>
                            <td>{{ user.created_at }}</td>
                            <td>{{ user.updated_at }}</td>
                            <td>
                                <Button type="primary" @click="showEditTag(user, index)">Edit</Button>
                                <Button type="error" @click="showDeletingModal(user.id, index)">Delete</Button>
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
            title="Add User"
            :mask-closable="false"
            :closable="false"
        >
            <div>
                <label>User Name</label>
                <Input type="text" v-model="data.user_name" placeholder="Enter something..." />
            </div>
            <div>
                <label>Full Name</label>
                <Input type="text" v-model="data.full_name" placeholder="Enter something..." />
            </div>
            <div>
                <label>Email</label>
                <Input type="email" v-model="data.email" placeholder="Enter something..." />
            </div>
            <div>
                <label>Password</label>
                <Input type="password" v-model="data.password" placeholder="Enter something..." />
            </div>
            <div>
                <label>Role</label>
                <div class="space">
                    <Select v-model="data.role" placeholder="Choose something...">
                        <Option
                            v-for="role in roles"
                            :value="role"
                            :key="role"

                        >
                            {{ role }}
                        </Option>
                    </Select>
                </div>
            </div>
            <div slot="footer">
                <Button type="default" @click="addModal=false">Cancel</Button>
                <Button type="primary" @click="addUser" :disabled="isAdding" :loading="isAdding">{{ isAdding ? "Adding.." : "Add User" }}</Button>
            </div>
        </Modal>
        <!--  End Modal Create  -->
        <!--  Modal Update  -->
<!--        <Modal-->
<!--            v-model="editModal"-->
<!--            title="Update Tag"-->
<!--            :mask-closable="false"-->
<!--            :closable="false"-->
<!--        >-->
<!--            <div>-->
<!--                <label>Tag Name</label>-->
<!--                <Input v-model="editData.name" placeholder="Enter something..." />-->
<!--            </div>-->
<!--            <div slot="footer">-->
<!--                <Button type="default" @click="editModal=false">Cancel</Button>-->
<!--                <Button type="primary" @click="updateTag(editData)" :disabled="isAdding" :loading="isAdding">{{ isAdding ? "Updating.." : "Update Tag" }}</Button>-->
<!--            </div>-->
<!--        </Modal>-->
        <!--  End Modal Update  -->
        <!-- Modal Delete  -->
<!--        <Modal-->
<!--            v-model="showModalDelete"-->
<!--            width="360"-->
<!--        >-->
<!--            <p slot="header" style="color:#f60;text-align:center">-->
<!--                <icon type="ios-information-circle"></icon>-->
<!--                <span>Delete confirmation</span>-->
<!--            </p>-->
<!--            <div style="text-align:center">-->
<!--                <p>Are you want to delete this tag ?</p>-->
<!--            </div>-->
<!--            <div slot="footer">-->
<!--                <Button type="error" size="large" long @click="deleteTag" :isloading="isDeleting">{{ isDeleting ? "Deleting.." : "Delete" }}</Button>-->
<!--            </div>-->
<!--        </Modal>-->
        <!-- End Modal Delete  -->
    </div>
</template>
<script>
import Vue from "vue";
import { roles } from "../../../enums/users";

export default {
    data () {
        return {
            roles,
            data: {
                user_name: "",
                full_name: "",
                email: "",
                password: "",
                role: "",
            },
            editData: {
                id: "",
                user_name: "",
                full_name: "",
                email: "",
                password: "",
                role: "",
            },
            users: {},
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
        this.users = await this.getUsers();
    },

    methods: {

        async getUsers() {
            const response = await this.callApi('get', 'api/admin/app/get_users');
            return response.data;
        },

        async addUser() {
            if (this.data.user_name.trim() == '') return this.error('The user name field is required.');
            if (this.data.full_name.trim() == '') return this.error('The full name field is required.');
            if (this.data.email.trim() == '') return this.error('The email field is required.');
            if (this.data.password.trim() == '') return this.error('The password field is required.');
            if (this.data.role.trim() == '') return this.error('The role field is required.');
            await this.callApi('post', 'api/admin/app/create_user', this.data).then((response) => {
                this.success('Tag has been added successfully!');
                this.users.unshift(response.data);
                this.addModal = false;
                this.data.name = "";
            }).catch((e) => {
                this.error();
            });
        },

        // async updateTag(editData) {
        //     if (this.editData.name.trim() == '') return this.error('The tag name field is required.');
        //
        //     await this.callApi('post', `api/admin/app/update_tag/${editData.id}`, this.editData).then((response) => {
        //         this.tags[this.index].name = this.editData.name;
        //         this.success('Tag has been update successfully!');
        //         this.editModal = false;
        //     }).catch((e) => {
        //         this.error();
        //     });
        // },

        // async deleteTag() {
        //     await this.callApi('post', `api/admin/app/delete_tag/${this.deleteItem}`).then((res) => {
        //         this.success('Tag has been delete successfully!');
        //         this.tags.splice(this.index, 1);
        //         this.showModalDelete = false;
        //     }).catch((e) => {
        //         this.error();
        //     });
        // },

        // showEditTag(tag, index) {
        //     let obj = {
        //         id: tag.id,
        //         name: tag.name
        //     };
        //
        //     this.editData = obj;
        //     this.editModal = true;
        //     this.index = index
        // },

        // showDeletingModal(tag, idx) {
        //     this.showModalDelete = true
        //     this.deleteItem = tag;
        //     this.index = idx;
        // }
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

