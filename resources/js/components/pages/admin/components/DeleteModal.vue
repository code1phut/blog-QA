<template>
<!-- Modal Delete  -->
    <Modal
        :value="this.getDeleteModalBased.showModalDelete"
        :mask-closable="true"
        :closable="true"
        width="360"
    >
        <p slot="header" style="color:#f60;text-align:center">
            <icon type="ios-information-circle"></icon>
            <span>Delete confirmation</span>
        </p>
        <div style="text-align:center">
            <p>Are you want to delete this category ?</p>
        </div>
        <div slot="footer">
            <Button type="error" size="large" long @click="deleteModal" :isloading="isDeleting">{{ isDeleting ? "Deleting.." : "Delete" }}</Button>
        </div>
    </Modal>
    <!-- End Modal Delete  -->
</template>

<script>
import {mapGetters} from "vuex";
export default {
    data() {
        return {
            isDeleting: false,
        }
    },

    computed: {
        ...mapGetters(['getDeleteModalBased']),
    },

    methods: {
        async deleteModal() {
            // await this.callApi('post', `api/admin/app/delete_tag/${this.deleteItem}`).then((res) => {
            console.log('url', this.getDeleteModalBased.deleteUrl)
            console.log('data', this.getDeleteModalBased.data)
            this.isDeleting = true;
            const  res = await this.callApi('post', this.getDeleteModalBased.deleteUrl);
            if (res.status === 200) {
                this.success('Category has been deleted successfully');
                this.$store.commit('setShowDeleteModal', true)
            } else {
                this.$store.commit('setShowDeleteModal', false)
                this.error();
            }
            this.isDeleting = false;
        },

    },
}
</script>
