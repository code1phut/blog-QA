<template>
    <div>
        <main id="page-top">
            <!-- Page Wrapper -->
            <div id="wrapper">

                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>
                <!-- Sidebar -->
                <Sidebar />
                <!-- End of Sidebar -->



                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">

                    <!-- Main Content -->
                    <router-view></router-view>
                    <!-- End of Main Content -->

                    <!-- Footer -->
                    <Footer />
                    <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->
        </main>
    </div>
</template>

<script>
import Sidebar from "./_share/_layouts/Sidebar";
import Footer from "./_share/_layouts/Footer";
export default {
    components: {
        Sidebar,
        Footer
    }
}
</script>
