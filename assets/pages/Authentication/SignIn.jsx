import React, {useEffect, useState} from 'react';
import {useDispatch, useSelector} from "react-redux";
import {authenticationActions} from "../../actions/authentication.actions";
import {history} from "../../helpers/history";
import CardHeader from "./components/CardHeader";
import CardBodyTitle from "./components/CardBodyTitle";
import Alert from "./components/Alert";
import InputField from "./components/InputField";
import SubmitButton from "./components/SubmitButton";
import UnderCardBlock from "./components/UnderCardBlock";

export default function SignIn() {
    const dispatch = useDispatch();
    const [isRegistered, setIsRegistered] = useState(!!history.location.isRegistered);
    const errors = useSelector(state => state.authentication.signIn.errors);
    const isLoading = useSelector(state => state.authentication.signIn.loggingIn);

    const handleChange = (e) => {
        const { name, value } = e.target;

        setInputs(inputs => ({ ...inputs, [name]: value }));
    }

    const handleSubmit = (e) => {
        e.preventDefault();

        if (isRegistered) {
            setIsRegistered(false);
        }

        if (email && password) {
            dispatch(authenticationActions.login(email, password, {pathname: "/"}));
        }
    }

    const [inputs, setInputs] = useState({email: '', password: ''});
    const {email, password} = inputs;

    return (
        <div className="my-5 pt-sm-5">
            <div className="container">
                <div className="justify-content-center row">
                    <div className="col-md-8 col-lg-6 col-xl-5">
                        <div className="overflow-hidden card">
                            <CardHeader/>
                            <div className="pt-0 card-body">
                                <CardBodyTitle
                                    title="Welcome Back!"
                                    description="Sign in to continue"
                                />
                                <div className="p-2">
                                    {errors?.domain.length > 0 &&
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
                        </div>

                        <UnderCardBlock
                            message="Don't have an account?"
                            link={{pathname: '/sign-up', label: 'Signup'}}
                        />
                    </div>
                </div>
            </div>
        </div>
    );
}
