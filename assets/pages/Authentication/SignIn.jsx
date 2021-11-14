import React, {useEffect, useState} from 'react';
import {useDispatch, useSelector} from "react-redux";
import {authenticationActions} from "../../actions/authentication.actions";
import CardBodyTitle from "./components/CardBodyTitle";
import Alert from "./components/Alert";
import InputField from "./components/InputField";
import SubmitButton from "./components/SubmitButton";
import {useNavigate} from "react-router-dom";

export default function SignIn() {
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const isRegistered = useSelector(state => state.authentication.signUp.isRegistered);
    const errors = useSelector(state => state.authentication.signIn.errors);
    const isLoading = useSelector(state => state.authentication.signIn.loggingIn);
    const loggedIn = useSelector(state => state.authentication.signIn.loggedIn);

    const handleChange = (e) => {
        const { name, value } = e.target;

        setInputs(inputs => ({ ...inputs, [name]: value }));
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        dispatch(authenticationActions.clearRegisterState());

        if (email && password) {
            dispatch(authenticationActions.login(email, password, {pathname: "/"}));
        }
    }

    useEffect(() => {
        if (loggedIn) {
            navigate('/');
        }
    },[loggedIn]);

    const [inputs, setInputs] = useState({email: '', password: ''});
    const {email, password} = inputs;

    return (
        <div className="pt-0 card-body">
            <CardBodyTitle
                title="Welcome Back!"
                description="Sign in to continue"
            />
            <div className="p-2">
                {errors?.domain?.length > 0 &&
                <Alert type="error" message={errors.domain[0].message}/>
                }

                {isRegistered &&
                <Alert type="success" message="Your account was successfully created. Now you can sign-in!"/>
                }

                <form className="form-horizontal" id="sign-in-form" onSubmit={handleSubmit}>
                    <div className="mb-3">
                        <InputField
                            name="email"
                            type="email"
                            label="Email"
                            placeholder="Enter email"
                            value={email}
                            onChange={handleChange}
                            error={errors?.validation?.email}
                            isRequired={true}
                        />
                    </div>
                    <div className="mb-3">
                        <InputField
                            name="password"
                            type="password"
                            label="Password"
                            placeholder="Enter password"
                            value={password}
                            onChange={handleChange}
                            error={errors?.validation?.password}
                            isRequired={true}
                        />
                    </div>

                    <div className="mt-5 d-grid">
                        <SubmitButton isLoading={isLoading} label="Sign in"/>
                    </div>
                </form>
            </div>
        </div>
    );
}
