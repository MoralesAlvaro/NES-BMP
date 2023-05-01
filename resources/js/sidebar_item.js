// Exportando la información para el componente del SideBar.
export const sidebarItems = [
    // {
    //     name: 'Dashboard',
    //     aria: 'dropdown1',
    //     icon: 'fas fa-chart-bar',
    //     children: [
    //         {
    //             name: 'Dashboard1',
    //             item_url: 'dashboard',
    //             icon: 'fa fa-circle fa-xs'
    //         },
    //         {
    //             name: 'Dashboard2',
    //             item_url: 'dashboard',
    //             icon: 'fa fa-circle fa-xs'
    //         }
    //     ]
    // },
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
                name: 'Stock',
                item_url: 'stock.list',
                icon: 'fa fa-circle fa-xs'
            },
            {
                name: 'Materia Prima',
                item_url: 'rawMaterial.list',
                icon: 'fa fa-circle fa-xs'
            },
            {
                name: 'Productos',
                item_url: 'product.list',
                icon: 'fa fa-circle fa-xs'
            },
            {
                name: 'Categorías',
                item_url: 'category.list',
                icon: 'fa fa-circle fa-xs'
            },
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
                name: 'Roles',
                item_url: 'roleList',
                icon: 'fa fa-circle fa-xs'
            },
            {
                name: 'Usuarios',
                item_url: 'user.list',
                icon: 'fa fa-circle fa-xs'
            }
        ]
    }
];
