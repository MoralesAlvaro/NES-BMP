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
                icon: 'fas fa-chart-bar'
            },
            {
                name: 'Dashboard2',
                item_url: 'dashboard',
                icon: 'fas fa-chart-bar'
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
                icon: 'fas fa-money-bill'
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
                icon: 'fas fa-boxes'
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
                icon: 'fas fa-paste'
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
                icon: 'fas fa-users'
            }
        ]
    }
];