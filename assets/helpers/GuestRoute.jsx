import React from 'react';
import { Route, Redirect } from 'react-router-dom';
import {authenticationService} from "../services/authentication.service";
import {useSelector} from "react-redux";

export default function GuestRoute({ component: Component, roles, ...rest }) {
    const isLoggedIn = useSelector(state => state.authentication.signIn.loggedIn);

    return (
        <Route {...rest} render={props => {

            if (isLoggedIn) {
                return <Redirect to={{ pathname: '/'}} />
            }

            return <Component {...props} />
        }} />
    );
}
