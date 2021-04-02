import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

import Home from './components/pages/admin/Home.vue';
import Posts from './components/pages/admin/Posts.vue';
import Categories from './components/pages/admin/Categories.vue';
import Tags from './components/pages/admin/Tags.vue';
import Users from './components/pages/admin/Users.vue';

const routes = [

    //home page
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/categories',
        name: 'categories',
        component: Categories,
    },
    {
        path: '/posts',
        name: '/posts',
        component: Posts,
    },
    {
        path: '/tags',
        name: '/tags',
        component: Tags,
    },
    {
        path: '/users',
        name: '/users',
        component: Users,
    }
];

export default new Router({
   routes
});
