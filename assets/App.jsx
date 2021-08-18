import React, {useEffect, useState} from 'react';
import PrivateRoute from "./helpers/PrivateRoute";
import {Router, Switch} from 'react-router-dom';
import {history} from "./helpers/history";
import Dashboard from "./pages/Dashboard";
import GuestRoute from "./helpers/GuestRoute";
import SignIn from "./pages/Authentication/SignIn";
import SignUp from "./pages/Authentication/SignUp";
import {authenticationService} from "./services/authentication.service";
import {useSelector} from "react-redux";
import Loading from "./components/Loading";

export default function App() {
    const isLoggedIn = useSelector(state => state.authentication.signIn.loggedIn) ?? null;

    console.log(isLoggedIn);

    if (isLoggedIn === null) {
        return <Loading/>;
    }

    return (
        <Router history={history}>
            <Switch>
                <GuestRoute exact path="/sign-in" component={SignIn}/>
                <GuestRoute exact path="/sign-up" component={SignUp}/>
                <PrivateRoute path="/" component={Dashboard}/>
            </Switch>
        </Router>
    );
}