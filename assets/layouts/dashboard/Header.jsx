import React from "react";
import {Dropdown} from "react-bootstrap";
import {authenticationActions} from "../../actions/authentication.actions";
import {useDispatch, useSelector} from "react-redux";
import {Link} from "react-router-dom";

export default function Header() {
    const dispatch = useDispatch();
    const user = useSelector(state => state.authentication.signIn.user);

    const handleLogoutClick = () => {
        dispatch(authenticationActions.logout());
    };

    return (
        <header
            id="header-id"
            style={{height: '70px', position: 'fixed', top: 0, right: 0, left: 0, zIndex: 1002, boxShadow: '0 0.75rem 1.5rem rgba(18, 38, 63, 0.03)', backgroundColor: '#fff'}}>
            <div
                style={{display: 'flex', justifyContent: 'space-between', alignItems: 'center', margin: '0 auto', height: '70px', padding: '0 12px 0 0'}}>
                <div style={{display: 'flex !important'}}>
                    <div
                        style={{padding: '0 1.5rem', width: '250px', textAlign: 'center', background: '#2a3042', height: '70px'}}>
                        <span style={{color: 'white', lineHeight: '70px'}}>4BL Project</span>
                    </div>
                </div>

                <div style={{display: 'flex !important', paddingRight: '50px'}}>
                    <div>
                        <Dropdown>
                            <Dropdown.Toggle
                                bsPrefix="dropdown-user-header"
                                style={{color: "black", height: '70px', boxShadow: 'none !important', border:0, borderRadius:0, lineHeight:1.5, backgroundColor: 'transparent', padding: '.47rem .75rem', fontSize: '.8125rem', transition: 'color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out', textAlign: 'center', verticalAlign: 'middle'}}
                            >
                                {user
                                    ? <span>{user.firstName} {user.lastName}</span>
                                    : <span>Profile</span>
                                }
                                <i className="bi bi-arrow-down-short"/>
                            </Dropdown.Toggle>

                            <Dropdown.Menu flip={false} popperConfig={{placement: "bottom", modifiers: [{name: 'offset', options: {offset: [-50, 0]}}, {name: 'preventOverflow', options: {mainAxis: false}}]}}>
                                <Dropdown.Item>
                                    <Link to='/profile' style={{textDecoration: 'none', color: 'black'}}>
                                        <i className="bi bi-person me-3" style={{fontSize: '16px'}}/>
                                        Profile
                                    </Link>
                                </Dropdown.Item>
                                <Dropdown.Item>
                                    <Link to='/settings' style={{textDecoration: 'none', color: 'black'}}>
                                        <i className="bi bi-gear me-3" style={{fontSize: '16px'}}/>
                                        Settings
                                    </Link>
                                </Dropdown.Item>

                                <Dropdown.Divider/>

                                <Dropdown.Item onClick={handleLogoutClick}>
                                    <i className="bi bi-power text-danger me-3" style={{fontSize: '16px'}}/>
                                    Logout
                                </Dropdown.Item>
                            </Dropdown.Menu>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </header>
    );
}