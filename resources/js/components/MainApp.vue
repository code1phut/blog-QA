<template>
    <div>
        <main>
            <!-- Page Wrapper -->
            <div id="wrapper">

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
