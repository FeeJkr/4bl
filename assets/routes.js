import {useRoutes} from "react-router-dom";
import React from "react";
import AuthLayout from "./layouts/AuthLayout";
import SignIn from "./pages/Authentication/SignIn";
import SignUp from "./pages/Authentication/SignUp";
import DashboardLayout from "./layouts/DashboardLayout";
import Dashboard from "./pages/Dashboard";
import {List as DocumentsList} from "./pages/Invoices/Documents/List";
import {List as ContractorsList} from "./pages/Invoices/Contractors/List";
import {Generate} from "./pages/Invoices/Documents/Generate";
import DocumentsLayout from "./layouts/invoices/DocumentsLayout";
import {Create as CreateContractor} from "./pages/Invoices/Contractors/Create";
import ContractorsLayout from "./layouts/invoices/ContractorsLayout";
import {Edit as EditContractor} from "./pages/Invoices/Contractors/Edit";
import {Edit as EditDocument} from "./pages/Invoices/Documents/Edit";
import Profile from "./pages/Account/Profile";
import Settings from "./pages/Account/Settings";
import CompanyLayout from "./layouts/invoices/CompanyLayout";

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
                            path: 'company',
                            element: <CompanyLayout/>,
                        },
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
                            path: 'contractors',
                            element: <ContractorsLayout/>,
                            children: [
                                { path: '', element: <ContractorsList/> },
                                { path: 'new', element: <CreateContractor/> },
                                { path: 'edit/:id', element: <EditContractor/> },
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