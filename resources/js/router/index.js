import VueRouter from 'vue-router'

//Exportamos una contante que donde obtendremos los roles que usaremos en todo el sistema
import {Role} from '@/helpers/autorize.js'

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
            roleuser:[Role.Administrator]  // de esta forma creamos un nuevo objecto con el rol que vamos a validar para esta vista o los roles
        }
    },
    {
        path: '/motivos',
        component: require('@/pages/Motivos/Index.vue').default,
        meta: {
            requiresAuth: true,
            roleuser:[Role.Administrator]  // de esta forma creamos un nuevo objecto con el rol que vamos a validar para esta vista o los roles
        }
    },
    {
        path: '/sedes',
        component: require('@/pages/Sedes/Index.vue').default,
        meta: {
            requiresAuth: true,
            roleuser:[Role.Administrator]  // de esta forma creamos un nuevo objecto con el rol que vamos a validar para esta vista o los roles
        }
    },
    {
        path: '/entidad',
        component: require('@/pages/Entidad/Index.vue').default,
        meta: {
            requiresAuth: true,
            roleuser:[Role.Administrator]  // de esta forma creamos un nuevo objecto con el rol que vamos a validar para esta vista o los roles
        }
    },
    {
        path: '/roles',
        component: require('@/pages/Roles/Index.vue').default,
        meta: {
            requiresAuth: true,
            roleuser:[Role.Administrator]  // de esta forma creamos un nuevo objecto con el rol que vamos a validar para esta vista o los roles
        }
    },
    {
        path: '/visitasP',
        component: require('@/pages/Visitas/VisitaPublic.vue').default,
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
               component: require('@/pages/Visitas/Natural.vue').default,
               meta: {
                    requiresAuth: true,
                },
            },
        
            {
               path: 'create',
               component: require('@/pages/Visitas/Add.vue').default,
                meta: {
                    requiresAuth: true,
                },
            },
            {
                path: 'edit/:id',
                component: require('@/pages/Visitas/Edit.vue').default,
                meta: {
                    requiresAuth: true,
                    roleuser:[Role.Administrator]  // de esta forma creamos un nuevo objecto con el rol que vamos a validar para esta vista o los roles

                },
            },
            {
                path: 'view/:id',
                component: require('@/pages/Visitas/View.vue').default,
                meta: {
                    requiresAuth: true,
                },
            },
  
        ]
    },
    {
        path: '/visitaprogramada',
        component: require('@/pages/Visitas/Programada.vue').default,
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: '/users',
        component: require('@/pages/Users/Index.vue').default,
        meta: {
            requiresAuth: true,
            roleuser:[Role.Administrator]

        }
    },
    {
        path: '/404',
        component: require('@/pages/404.vue').default,
        
    },


    

];
 
const router = new VueRouter({
    base:base_path_vue_router,
    routes,
    linkActiveClass: "active",
    mode: "history"
});

router.beforeEach((to, from, next) => {


    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!usauh) {
            location.href = route('login')
            return;
        }

        if (to.matched.some(record => record.meta.roleuser)) 
        {  
            let rolmeta = to.meta.roleuser;
            if (!rolmeta.includes(rolbyuser)) {
                return next({ path: '/404' });
            }
            return next()
        }else{
            return next()
        }
    }else{
       return next()
    }

})



export default router