// Exportando la información para el componente del SideBar.
export const sidebarItems = [
    {
        name: 'Dashboard',
        aria: 'dropdown1',
        icon: 'fas fa-chart-bar',
        children: [
            {
                name: 'Dashboard1',
                item_url: 'dashboard',
                icon: 'fa fa-circle fa-xs'
            },
            {
                name: 'Dashboard2',
                item_url: 'dashboard',
                icon: 'fa fa-circle fa-xs'
            }
        ]
    },
    {
        name: 'Ventas',
        aria: 'dropdown2',
        icon: 'fas fa-money-bill',
        children: [
            {
                name: 'Ventas1',
                item_url: 'sales',
                icon: 'fa fa-circle fa-xs'
            }
        ]
    },
    {
        name: 'Inventario',
        aria: 'dropdown3',
        icon: 'fas fa-boxes',
        children: [
            {
                name: 'Inventario1',
                item_url: 'inventory',
                icon: 'fa fa-circle fa-xs'
            }
        ]
    },
    {
        name: 'Reportes',
        aria: 'dropdown4',
        icon: 'fas fa-paste',
        children: [
            {
                name: 'Reportes1',
                item_url: 'report',
                icon: 'fa fa-circle fa-xs'
            }
        ]
    },
    {
        name: 'Roles y usuarios',
        aria: 'dropdown5',
        icon: 'fas fa-users',
        children: [
            {
                name: 'Roles y usuarios1',
                item_url: 'users',
                icon: 'fa fa-circle fa-xs'
            }
        ]
    }
];
