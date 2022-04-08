import React from "react";
import ErrorMessage from "./ErrorMessage";
import "./Input.css";

export default function Input(props) {
    const {
        name,
        label,
        placeholder,
        type,
        onChange,
        error,
        defaultValue,
    } = props;

    return (
        <div className="mb-3 form-group">
            <label
                htmlFor={name}
                style={{marginBottom: '.5rem', fontWeight: 500}}
            >
                {label}
            </label>
            <input id={name}
                   name={name}
                   placeholder={placeholder}
                   type={type}
                   className="form-control form-input"
                   style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                   onChange={onChange}
                   defaultValue={defaultValue}
            />
            {error && <ErrorMessage text={error.message}/>}
        </div>
    );
}
