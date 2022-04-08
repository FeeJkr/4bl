import React from "react";

export default function ErrorMessage(props) {
    return (
        <span style={{color: 'red', fontSize: '10px'}}>{props.text}</span>
    );
}