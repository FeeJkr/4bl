import React, {useState} from "react";
import {Link, Navigate, Outlet} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {history} from "../helpers/history";
import {authenticationActions} from "../actions/authentication.actions";
import {Collapse, Dropdown} from "react-bootstrap";
import Sidebar from "./dashboard/Sidebar";
import Loading from "../components/Loading";

export default function DashboardLayout() {
    const dispatch = useDispatch();
    const user = useSelector(state => state.authentication.signIn.user);
    const isLoggedIn = useSelector(state => state.authentication.signIn.loggedIn) ?? null;

    if (isLoggedIn === null) {
        return <Loading/>;
    }

    if (isLoggedIn === false) {
        return <Navigate to={'/auth/login'} replace/>
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

            <Sidebar/>

            <div style={{marginLeft: '250px', backgroundColor: '#f8f8fb'}}>
                <div style={{padding: '94px 12px 60px'}}>
                    <Outlet/>
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