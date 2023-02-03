import {useRoutes} from "react-router-dom";
import React from "react";
import AuthLayout from "./layouts/AuthLayout";
import SignIn from "./pages/Authentication/SignIn";
import SignUp from "./pages/Authentication/SignUp";
import DashboardLayout from "./layouts/DashboardLayout";
import Dashboard from "./pages/Dashboard";
import DocumentsList from "./pages/Invoices/Documents/list";
import {List as ContractorsList} from "./pages/Invoices/Contractors/List";
import GenerateDocument from "./pages/Invoices/Documents/generate";
import DocumentsLayout from "./layouts/invoices/DocumentsLayout";
import {Create as CreateContractor} from "./pages/Invoices/Contractors/Create";
import ContractorsLayout from "./layouts/invoices/ContractorsLayout";
import {Edit as EditContractor} from "./pages/Invoices/Contractors/Edit";
import {Edit as EditDocument} from "./pages/Invoices/Documents/Edit";
import Profile from "./pages/Account/Profile";
import Settings from "./pages/Account/Settings";
import CompaniesLayout from "./layouts/invoices/CompaniesLayout";
import BudgetPlannerLayout from "./layouts/finances/BudgetPlannerLayout";
import {List as BudgetsPeriodsList} from "./pages/Finances/Budgets/Periods/List";
import {Show as BudgetsPeriodsShow} from "./pages/Finances/Budgets/Periods/Show";
import CompaniesList from "./pages/Invoices/Companies/list";
import CreateCompany from "./pages/Invoices/Companies/create";
import EditCompany from "./pages/Invoices/Companies/edit";

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
                            path: 'companies',
                            element: <CompaniesLayout/>,
                            children: [
                                { path: '', element: <CompaniesList/> },
                                { path: 'new', element: <CreateCompany/> },
                                { path: 'edit/:id', element: <EditCompany/> },
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
                        {
                            path: 'documents',
                            element: <DocumentsLayout/>,
                            children: [
                                { path: '',  element: <DocumentsList/> },
                                { path: 'new', element: <GenerateDocument/> },
                                { path: 'edit/:id', element: <EditDocument/> },
                            ],
                        },
                    ],
                },
                {
                    path: 'finances',
                    children: [
                        { path: '', element: '<div>Dashboard finances</div>' },
                        {
                            path: 'budgets',
                            element: <BudgetPlannerLayout/>,
                            children: [
                                { path: '', element: <BudgetsPeriodsList/> },
                                { path: ':id', element: <BudgetsPeriodsShow/> },
                            ],
                        },
                        { path: 'categories', element: '<div>Categories finances</div>' },
                        { path: 'wallets', element: '<div>Wallets finances</div>' },
                    ]
                }
            ],
        }
    ]);
}