import React, {useEffect, useState} from 'react';
import './Dashboard.css';
import {Link} from "react-router-dom";
import {Collapse, Dropdown} from "react-bootstrap";
import { Router, Switch} from 'react-router-dom';
import {history} from "../helpers/history";
import PrivateRoute from "../helpers/PrivateRoute";
// companies
import {List as CompaniesList} from '../pages/Invoices/Companies/List';
import {Create as CompaniesCreate} from '../pages/Invoices/Companies/Create';
import {Edit as CompaniesEdit} from '../pages/Invoices/Companies/Edit';
// invoices
import {List as InvoicesList} from '../pages/Invoices/Invoices/List';
import {Generate as InvoicesGenerate} from '../pages/Invoices/Invoices/Generate';
import {Edit as InvoicesEdit} from "./Invoices/Invoices/Edit";
import {useDispatch, useSelector} from "react-redux";
import {authenticationActions} from "../actions/authentication.actions";
// finances
import {Dashboard as FinancesDashboard} from '../pages/Finances/Dashboard';
import {List as FinancesCategoriesList} from '../pages/Finances/Categories/List';
import {Create as FinancesCategoriesCreate} from '../pages/Finances/Categories/Create';
import {Edit as FinancesCategoriesEdit} from '../pages/Finances/Categories/Edit';
import {List as FinancesWalletsList} from '../pages/Finances/Wallets/List';
import {Create as FinancesWalletsCreate} from '../pages/Finances/Wallets/Create';
import {Edit as FinancesWalletsEdit} from '../pages/Finances/Wallets/Edit';

export default function Dashboard() {
    const dispatch = useDispatch();
    const isDashboardRoute = history.location.pathname === '/' || history.location.pathname === '';
    const isCompaniesRoute = history.location.pathname.startsWith('/companies');
    const isInvoicesRoute = history.location.pathname.startsWith('/invoices');
    const isFinancesRoute = history.location.pathname.startsWith('/finances');
    const isFinancesDashboardRoute = history.location.pathname.startsWith('/finances/dashboard');
    const isFinancesCategoriesRoute = history.location.pathname.startsWith('/finances/categories');

    let [openInvoices, setOpenInvoices] = useState(isCompaniesRoute || isInvoicesRoute);
    let [openFinances, setOpenFinances] = useState(isFinancesRoute);

    const user = useSelector(state => state.authentication.signIn.user);

    function collapseAll() {
        setOpenInvoices(false);
        setOpenFinances(false);
    }

    const handleLogoutClick = () => {
        dispatch(authenticationActions.logout());
    };

    return (
        <div style={{boxSizing: 'border-box', display: 'block'}}>
            <header
                id="header-id"
                style={{height: '70px', position: 'fixed', top: 0, right: 0, left: 0, zIndex: 1002, boxShadow: '0 0.75rem 1.5rem rgba(18, 38, 63, 0.03)', backgroundColor: '#fff'}}>
                <div
                    style={{display: 'flex', justifyContent: 'space-between', alignItems: 'center', margin: '0 auto', height: '70px', padding: '0 12px 0 0'}}>
                    <div style={{display: 'flex !important'}}>
                        <div
                            style={{padding: '0 1.5rem', width: '250px', textAlign: 'center', background: '#2a3042', height: '70px'}}>
                            <span style={{color: 'white', lineHeight: '70px'}}>4BL Project</span>
                        </div>
                    </div>

                    <div style={{display: 'flex !important', paddingRight: '50px'}}>
                        <div>
                            <Dropdown>
                                <Dropdown.Toggle
                                    bsPrefix="dropdown-user-header"
                                    style={{color: "black", height: '70px', boxShadow: 'none !important', border:0, borderRadius:0, lineHeight:1.5, backgroundColor: 'transparent', padding: '.47rem .75rem', fontSize: '.8125rem', transition: 'color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out', textAlign: 'center', verticalAlign: 'middle'}}
                                >
                                    {user
                                        ? <span>{user.firstName} {user.lastName}</span>
                                        : <span>Profile</span>
                                    }
                                    <i className="bi bi-arrow-down-short"/>
                                </Dropdown.Toggle>

                                <Dropdown.Menu flip={false} popperConfig={{placement: "bottom", modifiers: [{name: 'offset', options: {offset: [-50, 0]}}, {name: 'preventOverflow', options: {mainAxis: false}}]}}>
                                    <Dropdown.Item>
                                        <i className="bi bi-person me-3" style={{fontSize: '16px'}}/>
                                        Profile
                                    </Dropdown.Item>
                                    <Dropdown.Item>
                                        <i className="bi bi-gear me-3" style={{fontSize: '16px'}}/>
                                        Settings
                                    </Dropdown.Item>

                                    <Dropdown.Divider/>

                                    <Dropdown.Item onClick={handleLogoutClick}>
                                        <i className="bi bi-power text-danger me-3" style={{fontSize: '16px'}}/>
                                        Logout
                                    </Dropdown.Item>
                                </Dropdown.Menu>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </header>

            <div
                style={{width: '250px', zIndex: 1001, bottom: 0, marginTop: 0, position: 'fixed', top: '70px', boxShadow: '0 0.75rem 1.5rem rgba(18, 38, 63, 0.03)', background: '#2a3042'}}>
                <div style={{padding: '10px 0 30px'}}>
                    <ul style={{paddingLeft: 0, listStyle: 'none'}}>
                        <li className="menu-title"
                            style={{color: '#6a7187', padding: '12px 20px', letterSpacing: '.05em', pointerEvents: 'none', cursor: 'default', fontSize: '11px', textTransform: 'uppercase', fontWeight: 600}}>Menu
                        </li>

                        <li style={{display: 'block', width: '100%'}}>
                            <Link to="/"
                                style={{padding: '0.625rem 1.5rem', position: 'relative', fontSize: '13px', transition: 'all .4s', color: '#79829c', cursor: 'pointer', width: '100%', display: 'block', textDecoration: 'none'}}
                                onClick={collapseAll}
                                className={isDashboardRoute ? 'mm-active' : ''}
                            >
                                <i className="bi bi-house-door"
                                   style={{
                                       minWidth: '2rem',
                                       display: 'inline-block',
                                       paddingBottom: '.125em',
                                       fontSize: '1.25rem',
                                       lineHeight: '1.40625rem',
                                       verticalAlign: 'middle',
                                       transition: 'all .4s'
                                   }}
                                />
                                Dashboard
                            </Link>
                        </li>

                        <li style={{display: 'block', width: '100%'}}>
                            <a style={{padding: '.625rem 1.5rem', position: 'relative', fontSize: '13px', transition: 'all .4s', color: '#79829c', cursor: 'pointer', width: '100%', display: 'block', textDecoration: 'none'}}
                               onClick={() => { setOpenFinances(false); setOpenInvoices(!openInvoices); }}
                               aria-controls="invoices"
                               aria-expanded={openInvoices}
                               className={isCompaniesRoute || isInvoicesRoute ? 'mm-active' : ''}
                            >

                                <i className="bi bi-receipt"
                                   style={{
                                       minWidth: '2rem',
                                       display: 'inline-block',
                                       paddingBottom: '.125em',
                                       fontSize: '1.25rem',
                                       lineHeight: '1.40625rem',
                                       verticalAlign: 'middle',
                                       transition: 'all .4s'
                                   }}/>
                                Invoices

                                {openInvoices
                                    ? <i className="bi bi-arrow-up-short" style={{float: 'right', fontSize: '1.2rem'}}/>
                                    : <i className="bi bi-arrow-down-short" style={{float: 'right', fontSize: '1.2rem'}}/>
                                }
                            </a>
                            <Collapse in={openInvoices}>
                                <ul style={{padding: 0}}>
                                    <li style={{display: 'block', width: '100%', cursor: 'pointer'}}>
                                        <Link to={'/invoices'}
                                            style={{padding: '.4rem 1.5rem .4rem 3.5rem', fontSize: '13px', color: '#79829c', display: 'block', position: 'relative', textDecoration: 'none'}}
                                            className={isInvoicesRoute ? 'mm-active' : ''}
                                        >
                                            Invoices
                                        </Link>
                                    </li>
                                    <li style={{display: 'block', width: '100%', cursor: 'pointer'}}>
                                        <Link to={'/companies'}
                                            style={{padding: '.4rem 1.5rem .4rem 3.5rem', fontSize: '13px', color: '#79829c', display: 'block', position: 'relative', textDecoration: 'none'}}
                                            className={isCompaniesRoute ? 'mm-active' : ''}
                                        >
                                            Companies
                                        </Link>
                                    </li>
                                </ul>
                            </Collapse>
                        </li>

                        <li style={{display: 'block', width: '100%'}}>
                            <a style={{padding: '.625rem 1.5rem', position: 'relative', fontSize: '13px', transition: 'all .4s', color: '#79829c', cursor: 'pointer', width: '100%', display: 'block', textDecoration: 'none'}}
                               onClick={() => { setOpenInvoices(false); setOpenFinances(!openFinances) }}
                               aria-controls="finances"
                               aria-expanded={openFinances}
                               className={isFinancesRoute ? 'mm-active' : ''}
                            >

                                <i className="bi bi-cash-stack"
                                   style={{
                                       minWidth: '2rem',
                                       display: 'inline-block',
                                       paddingBottom: '.125em',
                                       fontSize: '1.25rem',
                                       lineHeight: '1.40625rem',
                                       verticalAlign: 'middle',
                                       transition: 'all .4s'
                                   }}/>
                                Finances

                                {openFinances
                                    ? <i className="bi bi-arrow-up-short" style={{float: 'right', fontSize: '1.2rem'}}/>
                                    : <i className="bi bi-arrow-down-short" style={{float: 'right', fontSize: '1.2rem'}}/>
                                }
                            </a>
                            <Collapse in={openFinances}>
                                <ul style={{padding: 0}}>
                                    <li style={{display: 'block', width: '100%', cursor: 'pointer'}}>
                                        <Link to={'/finances/dashboard'}
                                              style={{padding: '.4rem 1.5rem .4rem 3.5rem', fontSize: '13px', color: '#79829c', display: 'block', position: 'relative', textDecoration: 'none'}}
                                              className={isFinancesDashboardRoute ? 'mm-active' : ''}
                                        >
                                            Dashboard
                                        </Link>
                                    </li>
                                    <li style={{display: 'block', width: '100%', cursor: 'pointer'}}>
                                        <Link to={'/finances/categories'}
                                              style={{padding: '.4rem 1.5rem .4rem 3.5rem', fontSize: '13px', color: '#79829c', display: 'block', position: 'relative', textDecoration: 'none'}}
                                              className={isFinancesCategoriesRoute ? 'mm-active' : ''}
                                        >
                                            Categories
                                        </Link>
                                    </li>
                                </ul>
                            </Collapse>
                        </li>
                    </ul>
                </div>
            </div>

            <div style={{marginLeft: '250px', backgroundColor: '#f8f8fb'}}>
                <div style={{padding: '94px 12px 60px'}}>
                    <Router history={history}>
                        <Switch>
                            <PrivateRoute exact path={'/companies'} component={CompaniesList}/>
                            <PrivateRoute exact path={'/companies/create'} component={CompaniesCreate}/>
                            <PrivateRoute exact path={'/companies/edit/:id'} component={CompaniesEdit}/>

                            <PrivateRoute exact path={'/invoices'} component={InvoicesList}/>
                            <PrivateRoute exact path={'/invoices/generate'} component={InvoicesGenerate}/>
                            <PrivateRoute exact path={'/invoices/edit/:id'} component={InvoicesEdit}/>

                            <PrivateRoute exact path={'/finances/dashboard'} component={FinancesDashboard}/>
                            <PrivateRoute exact path={'/finances/categories'} component={FinancesCategoriesList}/>
                            <PrivateRoute exact path={'/finances/categories/create'} component={FinancesCategoriesCreate}/>
                            <PrivateRoute exact path={'/finances/categories/edit/:id'} component={FinancesCategoriesEdit}/>
                            <PrivateRoute exact path={'/finances/wallets'} component={FinancesWalletsList}/>
                            <PrivateRoute exact path={'/finances/wallets/create'} component={FinancesWalletsCreate}/>
                            <PrivateRoute exact path={'/finances/wallets/edit/:id'} component={FinancesWalletsEdit}/>

                        </Switch>
                    </Router>
                </div>
            </div>

            <footer className="footer">
                <div className="container-fluid">
                    <div className="row">
                        <div className="col-sm-6">
                            2021 © Mardeus Sergii Siryi
                        </div>
                        <div className="col-sm-6">
                            <div style={{textAlign: 'right'}}>
                                Design & Develop by Sergii Siryi
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    );
}