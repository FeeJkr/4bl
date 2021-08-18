import { authenticationConstants } from '../../constants/authentication.constants';
import {authenticationService} from "../../services/authentication.service";

export function signIn(state = {}, action) {
    switch (action.type) {
        case authenticationConstants.LOGIN_REQUEST:
            return {
                loggingIn: true,
            };
        case authenticationConstants.LOGIN_SUCCESS:
            return {
                loggedIn: true,
                user: action.user,
            };
        case authenticationConstants.LOGIN_FAILURE:
            return {
                loggedIn: false,
                errors: action.errors,
            };
        case authenticationConstants.LOGIN_CLEAR_STATE:
            return {};
        case authenticationConstants.LOGOUT:
            return {
                loggedIn: false,
            };

        default:
            return state
    }
}

export async function isLoggedIn(dispatch, getState) {
    const response = await authenticationService.me();

    if (response !== false) {
        dispatch({type: authenticationConstants.LOGIN_SUCCESS, user: response})
    } else {
        dispatch({type: authenticationConstants.LOGIN_FAILURE})
    }
}