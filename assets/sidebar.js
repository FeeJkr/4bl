const sidebar = [
    {
        title: 'Dashboard',
        path: '/',
        icon: 'bi-house-door',
    },
    {
        title: 'Invoices',
        icon: 'bi-receipt',
        children: [
            {
                title: 'Company',
                path: '/invoices/company',
                icon: 'bi-house-door',
            },
            {
                title: 'Documents',
                path: '/invoices/documents',
                icon: 'bi-file-earmark-binary',
                children: [
                    { path: '/invoices/documents/new' },
                    { path: '/invoices/documents/edit/:id' },
                ]
            },
            {
                title: 'Contractors',
                path: '/invoices/contractors',
                icon: 'bi-building',
                children: [
                    { path: '/invoices/contractors/new' },
                    { path: '/invoices/contractors/edit/:id' },
                ],
            }
        ]
    },
    {
        title: 'Finances',
        icon: 'bi-cash-stack',
        children: [
            {
                title: 'Dashboard',
                path: '/finances',
                icon: 'bi-speedometer',
            },
            {
                title: 'Categories',
                path: '/finances/categories',
                icon: 'bi-bookshelf',
            },
            {
                title: 'Wallets',
                path: '/finances/wallets',
                icon: 'bi-wallet',
            }
        ]
    }
];

export default sidebar;