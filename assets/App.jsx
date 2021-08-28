import React from 'react';
import {useSelector} from "react-redux";
import Loading from "./components/Loading";
import ScrollToTop from "./components/ScrollToTop";
import Router from "./routes";

export default function App() {
    return (
        <>
            <ScrollToTop/>
            <Router/>
        </>
    );
}