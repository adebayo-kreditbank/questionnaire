<template>
    <div id="wrapper">
        <!-- Sidebar -->
        <SideBar />
        <!-- /Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- TopBar -->
                <TopBar />
                <!-- Topbar -->

                <!-- Container Fluid-->
                <router-view />
                <!---Container Fluid-->

            </div>


            <!-- Modal Logout -->
                <Modal />
            <!-- Modal Logout -->

            <!-- Footer -->
                <FooterBar />
            <!-- Footer -->
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</template>

<script>
import SideBar from '../layout/SideBar.vue'
import TopBar from '../layout/TopBar.vue'
import Modal from '../layout/Modal.vue'
import FooterBar from '../layout/Footer.vue'


export default {
    components: {
        SideBar,
        TopBar,
        Modal,
        FooterBar
    }

}
</script>