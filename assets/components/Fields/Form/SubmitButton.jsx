import React from "react";

export default function SubmitButton(props) {
    return (
        <div className="justify-content-end row">
            <div className="col-lg-12">
                <input type="submit" className="btn btn-primary" style={{fontSize: '13px'}} value="Save Changes"/>
            </div>
        </div>
    );
}