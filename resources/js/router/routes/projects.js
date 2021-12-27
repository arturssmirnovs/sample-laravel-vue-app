export default [
    {
        path: 'projects/:id(\\d+)',
        name: 'ProjectsView',
        component: () => import('@/js/views/projects/View'),
        props: route => ({
            id: route.params.id
        })
    },
    {
        path: 'projects',
        name: 'ProjectsIndex',
        component: () => import('@/js/views/projects/Index'),
    }
]
