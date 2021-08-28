import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import {store} from "./helpers/store";
import {Provider} from "react-redux";
import './app.css';
import 'boxicons';
import {isLoggedIn} from "./reducers/authentication/sign-in.reducer";
import {BrowserRouter} from "react-router-dom";

store.dispatch(isLoggedIn);

ReactDOM.render(
    <Provider store={store}>
        <BrowserRouter>
            <App />
        </BrowserRouter>
    </Provider>,
    document.getElementById('root')
);
