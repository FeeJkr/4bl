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
                title: 'Documents',
                path: '/invoices/documents',
                icon: 'bi-file-earmark-binary',
                children: [
                    { path: '/invoices/documents/new' },
                    { path: '/invoices/documents/edit/:id' },
                ]
            },
            {
                title: 'Companies',
                path: '/invoices/companies',
                icon: 'bi-house-door',
                children: [
                    { path: '/invoices/companies/new' },
                    { path: '/invoices/companies/edit/:id' },
                ],
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
];

export default sidebar;