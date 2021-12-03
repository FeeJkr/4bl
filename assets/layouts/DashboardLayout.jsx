import React from "react";
import {Navigate, Outlet} from "react-router-dom";
import {useSelector} from "react-redux";
import Sidebar from "./dashboard/Sidebar";
import Loading from "../components/Loading";
import Footer from "./dashboard/Footer";
import Header from "./dashboard/Header";

export default function DashboardLayout() {
    const isLoggedIn = useSelector(state => state.authentication.signIn.loggedIn) ?? null;

    if (isLoggedIn === null) {
        return <Loading/>;
    }

    if (isLoggedIn === false) {
        return <Navigate to={'/auth/login'} replace/>
    }

    return (
        <div style={{boxSizing: 'border-box', display: 'block'}}>
            <Header/>
            <Sidebar/>

            <div style={{marginLeft: '250px', backgroundColor: '#f8f8fb'}}>
                <div style={{padding: '94px 12px 60px'}}>
                    <Outlet/>
                </div>
            </div>

            <Footer/>
        </div>
    );
}