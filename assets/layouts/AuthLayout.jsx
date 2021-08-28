import React from "react";
import {Navigate, Outlet, useLocation} from "react-router-dom";
import CardHeader from "../pages/Authentication/components/CardHeader";
import UnderCardBlock from "../pages/Authentication/components/UnderCardBlock";
import {useSelector} from "react-redux";
import Loading from "../components/Loading";

export default function AuthLayout() {
    const location = useLocation();
    const isRegisterPath = location.pathname.includes('/auth/register');
    const isLoggedIn = useSelector(state => state.authentication.signIn.loggedIn) ?? null;

    if (isLoggedIn === null) {
        return <Loading/>;
    }

    if (isLoggedIn === true) {
        return <Navigate to={'/'} replace/>
    }

    return (
        <div className="my-5 pt-sm-5">
            <div className="container">
                <div className="justify-content-center row">
                    <div className="col-md-8 col-lg-6 col-xl-5">
                        <div className="overflow-hidden card">
                            <CardHeader/>
                            <Outlet/>
                        </div>

                        {isRegisterPath
                            ? (<UnderCardBlock message="Already have an account?" link={{pathname: '/auth/login', label: 'Login'}}/>)
                            : (<UnderCardBlock message="Don't have an account?" link={{pathname: '/auth/register', label: 'Register'}}/>)
                        }
                    </div>
                </div>
            </div>
        </div>
    );
}