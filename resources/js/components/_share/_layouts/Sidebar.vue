<template>
    <div>
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <router-link
                to="/"
                exact
                class="sidebar-brand d-flex align-items-center justify-content-center"
            >
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"> Blog <sup>QA</sup></div>
            </router-link>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Dashboard -->
            <li class="nav-item active">
                <router-link
                    to="/"
                    class="nav-link"
                    exact
                >
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </router-link>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Category -->
            <li class="nav-item">
                <router-link
                    to="/categories"
                    exact
                    class="nav-link collapsed"
                    data-toggle="collapse"
                    data-target="#collapseTwo"
                    aria-expanded="true"
                    aria-controls="collapseTwo"
                >
                    <i class="fa fa-archive" aria-hidden="true"></i>
                    <span>Category</span>
                </router-link>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <!-- TODO drop down-->
                </div>
            </li>
            <hr class="sidebar-divider">
            <!-- Posts -->
            <li class="nav-item">
                <router-link
                    to="/posts"
                    class="nav-link collapsed"
                    data-toggle="collapse"
                    data-target="#collapseUtilities"
                    aria-expanded="true"
                    aria-controls="collapseUtilities"
                >
                    <i class="fa fa-book" aria-hidden="true"></i>
                    <span>Posts</span>
                </router-link>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Tags -->
            <li class="nav-item">
                <router-link
                    to="/tags"
                    class="nav-link collapsed"
                    data-toggle="collapse"
                    data-target="#collapseUtilities"
                    aria-expanded="true"
                    aria-controls="collapseUtilities"
                >
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <span>Tags</span>
                </router-link>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Users -->
            <li class="nav-item">
                <router-link
                    to="/users"
                    class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages"
                >
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <span>Users</span>
                </router-link>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
    </div>
</template>
