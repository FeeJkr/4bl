import axios from "axios";

export const authenticationService = {
    me,
    login,
    register,
    logout,
};

function me() {
    return axios.get('/api/v1/accounts/me')
        .then((response) => {
            localStorage.setItem('user', JSON.stringify(response.data));

            return response.data;
        })
        .catch(() => {
            localStorage.removeItem('user');

            return false;
        });
}

function login(email, password) {
    return axios.post('/api/v1/accounts/sign-in', {
        email: email,
        password: password,
    })
        .then((response) => {
            return me();
        })
        .catch(handleError);
}

function register(email, username, password, firstName, lastName) {
    return axios.post('/api/v1/accounts/register', {
        email: email,
        username: username,
        password: password,
        firstName: firstName,
        lastName: lastName,
    })
        .then(handleNoContentResponse)
        .catch(handleError);
}

function logout() {
    localStorage.removeItem('user');

    return axios.post('/api/v1/accounts/logout');
}

function handleNoContentResponse(response) {
    return response;
}

function handleError(error) {
    const response = error.response;

    if (response.status === 403) {
        logout();
    }

    return Promise.reject(response.data);
}
