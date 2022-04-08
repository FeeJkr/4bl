import React from "react";

export default function Switch(props) {
    const {
        name,
        label,
        onChange,
        defaultChecked,
    } = props;
    return (
        <div className="mb-3 form-group" style={{marginLeft: '2rem'}}>
            <div className="form-check form-switch" style={{fontSize: '1.2rem'}}>
                <input className="form-check-input" name={name} type="checkbox" id={name} onChange={onChange} defaultChecked={defaultChecked}/>
                <label className="form-check-label" style={{marginBottom: '.5rem', fontWeight: 500, fontSize: '.8125rem'}} htmlFor={name}>{label}</label>
            </div>
        </div>
    );
}
