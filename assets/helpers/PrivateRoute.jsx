import React from 'react';
import { Route, Redirect } from 'react-router-dom';
import {useSelector} from "react-redux";

function PrivateRoute({ component: Component, roles, ...rest }) {
    const isLoggedIn = useSelector(state => state.authentication.signIn.loggedIn) ?? null;

    return (
        <Route {...rest} render={props => {
            if (isLoggedIn) {
                return <Component {...props} />
            }

            return <Redirect to={{ pathname: '/sign-in', state: { from: props.location } }} />
        }} />
    );
}

export default PrivateRoute;