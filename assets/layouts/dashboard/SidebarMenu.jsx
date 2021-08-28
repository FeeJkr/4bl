import sidebarConfig from "../../sidebar";
import {Link, matchPath, useLocation} from "react-router-dom";
import {Collapse} from "react-bootstrap";
import React from "react";
import SidebarMenuItem from "./SidebarMenuItem";

export default function SidebarMenu() {
    const {pathname} = useLocation();
    const match = path => (path ? !!matchPath({path, end: true}, pathname) : false);

    return (
        <div style={{padding: '10px 0 30px'}}>
            <ul style={{paddingLeft: 0, listStyle: 'none'}}>
                <li className="menu-title"
                    style={{color: '#6a7187', padding: '12px 20px', letterSpacing: '.05em', pointerEvents: 'none', cursor: 'default', fontSize: '11px', textTransform: 'uppercase', fontWeight: 600}}>Menu
                </li>
                {sidebarConfig.map((item) => (
                    <SidebarMenuItem key={item.title} item={item} active={match}/>
                ))}
            </ul>
        </div>
    );
}