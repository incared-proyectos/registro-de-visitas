import VueRouter from 'vue-router'
//component: () => import( "@/pages/Pruebas.vue"), IMPORT LAZY LOADING FAST

let routes = [
	{
		path: '/home',
        component: require('@/pages/Home.vue').default,
        meta: {
            requiresAuth: true,
        }
	},
    {
        path: '/oficinas',
        component: require('@/pages/Oficinas/Index.vue').default,
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: '/visitas',
        component: require('@/pages/App.vue').default,
        meta: {
            requiresAuth: true,
        },
        children: [
            {

              path: '',
              component: require('@/pages/Visitas/Index.vue').default

            },
            {
              path: 'create',
              component: require('@/pages/Visitas/Add.vue').default
            },
            {
              path: 'edit/:id',
              component: require('@/pages/Visitas/Edit.vue').default
            },
            {
              path: 'view/:id',
              component: require('@/pages/Visitas/View.vue').default
            },
  
        ]
    },
    {
        path: '/users',
        component: require('@/pages/Users/Index.vue').default,
        meta: {
            requiresAuth: true,
        }
    },


    

];
 
 
export default new VueRouter({
    base:base_path_vue_router,
    routes,
    linkActiveClass: "active",
    mode: "history"
});