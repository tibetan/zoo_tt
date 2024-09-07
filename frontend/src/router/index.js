import { createRouter, createWebHistory } from 'vue-router';
import CalculatePrice from '../components/CalculatePrice.vue';
import ShippingList from '../components/ShippingList.vue';

const routes = [
    {
        path: '/',
        name: 'CalculatePrice',
        component: CalculatePrice,
        props: { msg: 'Shipping Calculator' }
    },
    {
        path: '/shipping-list',
        name: 'ShippingList',
        component: ShippingList,
        props: { msg: 'Shipping List' }
    },
];

const router = createRouter({
    history: createWebHistory(process.env.VUE_APP_BASE_URL),
    routes
});

export default router;
