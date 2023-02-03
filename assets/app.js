import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import {store} from "./reducers/store";
import {Provider} from "react-redux";
import './app.css';
import 'boxicons';
import {isLoggedIn} from "./reducers/authentication/sign-in.reducer";
import {BrowserRouter} from "react-router-dom";
import {Toaster} from "react-hot-toast";

store.dispatch(isLoggedIn);

ReactDOM.render(
    <Provider store={store}>
        <BrowserRouter>
            <App />
            <Toaster position="top-right" toastOptions={{className: 'react-hot-toast'}}/>
        </BrowserRouter>
    </Provider>,
    document.getElementById('root')
);
