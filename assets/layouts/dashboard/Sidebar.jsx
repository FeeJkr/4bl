import {Link} from "react-router-dom";
import {Collapse} from "react-bootstrap";
import React from "react";
import SidebarMenu from "./SidebarMenu";

export default function Sidebar() {
    return (
        <div
            style={{width: '250px', zIndex: 1001, bottom: 0, marginTop: 0, position: 'fixed', top: '70px', boxShadow: '0 0.75rem 1.5rem rgba(18, 38, 63, 0.03)', background: '#2a3042'}}>

            <SidebarMenu/>
        </div>
    );
}