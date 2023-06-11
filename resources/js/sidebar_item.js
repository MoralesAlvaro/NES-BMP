// Exportando la información para el componente del SideBar.
export const sidebarItems = [
    {
        name: 'Ventas',
        aria: 'dropdown2',
        icon: 'fas fa-money-bill',
        children: [
            {
                name: 'Ventas',
                item_url: 'sale.list',
                icon: 'fa fa-circle fa-xs'
            }
        ]
    },
    {
        name: 'Inventario',
        aria: 'dropdown4',
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
        aria: 'dropdown5',
        icon: 'fas fa-paste',
        children: [
            {
                name: 'Venta Diaria',
                item_url: 'dailySales',
                icon: 'fa fa-circle fa-xs'
            },
            {
                name: 'Bitácora ventas',
                item_url: 'saleLog',
                icon: 'fa fa-circle fa-xs'
            },
            {
                name: 'Gastos generales',
                item_url: 'expense.list',
                icon: 'fa fa-circle fa-xs'
            }
        ]
    },
    {
        name: 'Roles y usuarios',
        aria: 'dropdown6',
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
    },
    {
        name: 'Hacer Respaldo',
        aria: 'dropdown7',
        icon: 'fas fa-download',
        children: [
            {
                name: 'Respaldar Todo',
                item_url: 'allBackup',
                icon: 'fa fa-circle fa-xs'
            }
        ]
    }
];
