import React, {useState} from "react";
import {Link} from "react-router-dom";
import {Collapse} from "react-bootstrap";

export default function SidebarMenuItem({item, active}) {
    const {title, path, icon, children} = item;

    const isActiveRoot = children
        ? searchChildrenTree(children).filter(path => active(path)).length > 0
        : active(path);

    const [open, setOpen] = useState(isActiveRoot);

    const handleOpen = () => {
        setOpen(prev => !prev);
    }

    if (children) {
        return (
            <li style={{display: 'block', width: '100%'}}>
                <a style={{padding: '.625rem 1.5rem', position: 'relative', fontSize: '13px', transition: 'all .4s', color: '#79829c', cursor: 'pointer', width: '100%', display: 'block', textDecoration: 'none'}}
                   onClick={handleOpen}
                   aria-controls="invoices"
                   className={isActiveRoot ? 'mm-active' : ''}
                >
                    <i className={`bi ${icon}`}
                       style={{
                           minWidth: '2rem',
                           display: 'inline-block',
                           paddingBottom: '.125em',
                           fontSize: '1.25rem',
                           lineHeight: '1.40625rem',
                           verticalAlign: 'middle',
                           transition: 'all .4s'
                       }}/>
                    {title}

                    {open
                        ? <i className="bi bi-arrow-up-short" style={{float: 'right', fontSize: '1.2rem'}}/>
                        : <i className="bi bi-arrow-down-short" style={{float: 'right', fontSize: '1.2rem'}}/>
                    }
                </a>
                <Collapse in={open} unmountOnExit>
                    <ul style={{padding: 0}}>
                        {children.map(item => {
                            const {title, path, icon, children} = item;
                            let paths = [];

                            if (children) {
                                paths = searchChildrenTree(children);
                                paths.push(path);
                            }

                            const isActiveSub = children
                                ? paths.filter(path => active(path)).length > 0
                                : active(path);

                            return (
                                <li style={{display: 'block', width: '100%', cursor: 'pointer'}} key={title}>
                                    <Link to={path}
                                          style={{padding: '.4rem 1.5rem .4rem 3.5rem', fontSize: '13px', color: '#79829c', display: 'block', position: 'relative', textDecoration: 'none'}}
                                          className={isActiveSub ? 'mm-active' : ''}
                                    >
                                        <i className={`bi ${icon}`}/>
                                        <span style={{marginLeft: '10px'}}>{title}</span>
                                    </Link>
                                </li>
                            );
                        })}
                    </ul>
                </Collapse>
            </li>
        );
    }

    return (
        <li style={{display: 'block', width: '100%'}}>
            <Link to={path}
                  style={{padding: '0.625rem 1.5rem', position: 'relative', fontSize: '13px', transition: 'all .4s', color: '#79829c', cursor: 'pointer', width: '100%', display: 'block', textDecoration: 'none'}}
                  className={isActiveRoot ? 'mm-active' : ''}
            >
                <i className={`bi ${icon}`}
                   style={{
                       minWidth: '2rem',
                       display: 'inline-block',
                       paddingBottom: '.125em',
                       fontSize: '1.25rem',
                       lineHeight: '1.40625rem',
                       verticalAlign: 'middle',
                       transition: 'all .4s'
                   }}
                />
                {title}
            </Link>
        </li>
    );
}

function searchChildrenTree(children, paths = []) {
    children.forEach(item => {
        paths.push(item.path);

        if (item.children) {
            return searchChildrenTree(item.children, paths);
        }
    });

    return paths;
}