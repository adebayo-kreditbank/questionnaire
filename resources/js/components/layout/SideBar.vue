<template>
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="Javascript:void(0)">
            <div class="sidebar-brand-icon">
                <!-- <img src="img/logo/logo2.png"> -->
            </div>
            <div class="sidebar-brand-text mx-3">Manual</div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <router-link class="nav-link" :to="{ name: 'dashboard' }">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></router-link>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Manage Questionnaire
        </div>

        <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'question' }">
                <i class="fas fa-question fa-palette"></i>
                <span>Questions</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'answer' }">
                <i class="fas fa-question-circle fa-palette"></i>
                <span>Answer Options</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'mapping' }">
                <i class="fas fa-question-circle fa-palette"></i>
                <span>Mapping</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'behaviour' }">
                <i class="fas fa-users fa-palette"></i>
                <span>Behaviours</span>
            </router-link>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Manage Products
        </div>
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-fw fa-palette"></i>
                <span>Products</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-shopping-cart fa-palette"></i>
                <span>Category</span>
            </a>
        </li>
        <hr class="sidebar-divider">
    </ul>
</template>