import Vue from "vue";
import VueRouter from "vue-router";


Vue.use(VueRouter);

export default new VueRouter({
    linkActiveClass: "active",
    linkExactActiveClass: "",
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    routes: [
        {
            path: '/employee',
            name: 'Employee Main Component',
            props: true,
            component: () => import('../components/employee/EmployeeMainComponent.vue'),
            children: [
                {
                    path: '/employees',
                    name: 'Employee List',
                    props: true,
                    component: () => import('../components/employee/EmployeeIndex.vue')
                }
            ]
        },
        {
            path: '/category',
            name: 'Category Main Component',
            props: true,
            component: () => import('../components/Category/CategoryMainComponent.vue'),
            children: [
                {
                    path: '/categories',
                    name: 'Category List',
                    props: false,
                    component: () => import('../components/Category/CategoryIndex.vue')
                }
            ]
        },
        {
            path: '/item',
            name: 'Item Main Component',
            props: true,
            component: () => import('../components/item/ItemMainComponent.vue'),
            children: [
                {
                    path: '/items',
                    name: 'Item List',
                    props: false,
                    component: () => import('../components/item/ItemIndex.vue')
                }
            ]
        },
        {
            path: '/stock',
            name: 'Stock Main Component',
            props: true,
            component: () => import('../components/stock/StockMainComponent.vue'),
            children: [
                {
                    path: '/stocks',
                    name: 'Stock List',
                    props: false,
                    component: () => import('../components/stock/StockIndex.vue')
                }
            ]
        },
        {
            path: '/area',
            name: 'Area Main Component',
            props: true,
            component: () => import('../components/area/AreaMainComponent.vue'),
            children: [
                {
                    path: '/areas',
                    name: 'Area List',
                    props: false,
                    component: () => import('../components/area/AreaIndex.vue')
                }
            ]
        },
        {
            path: '/attendances',
            name: 'Attendance Main Component',
            props: true,
            component: () => import('../components/attendance/AttendanceMainComponent.vue'),
            children: [
                {
                    path: '/attendance',
                    name: 'Attendance List',
                    props: false,
                    component: () => import('../components/attendance/AttendanceIndex.vue')
                }
            ]
        },
        {
            path: '/deploy',
            name: 'Deploy Main Component',
            props: true,
            component: () => import('../components/deploy/DeployMainComponent.vue'),
            children: [
                {
                    path: '/deploy',
                    name: 'Deploy List',
                    props: false,
                    component: () => import('../components/deploy/DeployIndex.vue')
                }
            ]
        },
        {
            path: '/qrcode',
            name: 'QrCode Main Component',
            props: true,
            component: () => import('../components/qrcode/QrcodeMainComponent.vue'),
            children: [
                {
                    path: '/codes',
                    name: 'Qrcode List',
                    props: false,
                    component: () => import('../components/qrcode/QrcodeIndex.vue')
                }
            ]
        },
        {
            path: '/deploy-employee',
            name: 'Deploy Employee Main Component',
            props: true,
            component: () => import('../components/deploy_employee/DeployEmployeeMainComponent.vue'),
            children: [
                {
                    path: '/deploy-employees',
                    name: 'Deploy Employee List',
                    props: false,
                    component: () => import('../components/deploy_employee/DeployEmployeeIndex.vue')
                }
            ]
        }
    ]
})
