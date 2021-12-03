import {useRoutes} from "react-router-dom";
import React from "react";
import AuthLayout from "./layouts/AuthLayout";
import SignIn from "./pages/Authentication/SignIn";
import SignUp from "./pages/Authentication/SignUp";
import DashboardLayout from "./layouts/DashboardLayout";
import Dashboard from "./pages/Dashboard";
import {List as DocumentsList} from "./pages/Invoices/Documents/List";
import {List as CompaniesList} from "./pages/Invoices/Companies/List";
import {Generate} from "./pages/Invoices/Documents/Generate";
import DocumentsLayout from "./layouts/invoices/DocumentsLayout";
import {Create as CreateCompany} from "./pages/Invoices/Companies/Create";
import CompaniesLayout from "./layouts/invoices/CompaniesLayout";
import {Edit as EditCompany} from "./pages/Invoices/Companies/Edit";
import {Edit as EditDocument} from "./pages/Invoices/Documents/Edit";
import Profile from "./pages/Account/Profile";
import Settings from "./pages/Account/Settings";

export default function Router() {
    return useRoutes([
        {
            path: '/auth',
            element: <AuthLayout/>,
            children: [
                { path: 'login', element: <SignIn/> },
                { path: 'register', element: <SignUp/> },
            ]
        },
        {
            path: '/',
            element: <DashboardLayout/>,
            children: [
                { path: '/', element: <Dashboard/> },
                { path: '/profile', element: <Profile/>},
                { path: '/settings', element: <Settings/> },
                {
                    path: 'invoices',
                    children: [
                        {
                            path: 'documents',
                            element: <DocumentsLayout/>,
                            children: [
                                { path: '',  element: <DocumentsList/> },
                                { path: 'new', element: <Generate/> },
                                { path: 'edit/:id', element: <EditDocument/> },
                            ],
                        },
                        {
                            path: 'companies',
                            element: <CompaniesLayout/>,
                            children: [
                                { path: '', element: <CompaniesList/> },
                                { path: 'new', element: <CreateCompany/> },
                                { path: 'edit/:id', element: <EditCompany/> },
                            ],
                        },
                    ],
                },
                {
                    path: 'finances',
                    children: [
                        { path: '', element: '<div>Dashboard finances</div>' },
                        { path: 'categories', element: '<div>Categories finances</div>' },
                        { path: 'wallets', element: '<div>Wallets finances</div>' },
                    ]
                }
            ],
        }
    ]);
}