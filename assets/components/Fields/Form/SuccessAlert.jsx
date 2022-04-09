import React from "react";
import {Toast} from "react-bootstrap";

export default function SuccessAlert({show, onClose, text}) {
    return (
        <div style={{position: 'absolute', bottom: 80, right: 20}}>
            <Toast style={{backgroundColor: '#00ca72'}}
                   onClose={onClose}
                   show={show}
                   delay={3000}
                   autohide
            >
                <Toast.Header closeButton={false} style={{backgroundColor: '#00ca72', borderBottom: 0}}>
                    <strong className="me-auto" style={{color: '#fff'}}>Success!</strong>
                </Toast.Header>
                <Toast.Body style={{color: '#fff'}}>
                    {text}
                </Toast.Body>
            </Toast>
        </div>
    );
}
