import React, {useEffect, useState} from 'react';
import {authenticationActions} from "../../actions/authentication.actions";
import {useDispatch, useSelector} from "react-redux";
import {history} from "../../helpers/history";
import InputField from "./components/InputField";
import SubmitButton from "./components/SubmitButton";
import CardHeader from "./components/CardHeader";
import CardBodyTitle from "./components/CardBodyTitle";
import Alert from "./components/Alert";
import UnderCardBlock from "./components/UnderCardBlock";

const SignUp = () => {
    const dispatch = useDispatch();
    const errors = useSelector(state => state.authentication.signUp.errors);
    const isLoading = useSelector(state => state.authentication.signUp.isLoading);

    useEffect(() => {
        return history.listen((location) => {
            dispatch(authenticationActions.clearRegisterState());
        });
    },[history]);

    const handleChange = (e) => {
        const {name, value} = e.target;
        setInputs(inputs =>({ ...inputs, [name]: value}));
    }

    const handleSubmit = (e) => {
        e.preventDefault();

        if (email && password && username && firstName && lastName) {
            dispatch(authenticationActions.register(email, username, password, firstName, lastName));
        }
    }

    const [inputs, setInputs] = useState({
        email: '',
        username: '',
        password: '',
        firstName: '',
        lastName: '',
    });
    const {email, username, password, firstName, lastName} = inputs;

    return (
        <div className="pt-0 card-body">
            <CardBodyTitle
                title="Start your adventure now!"
                description="Get your free account"
            />

            <div className="p-2">
                {errors?.domain.length > 0 && <Alert type="error" message={errors.domain[0].message} />}

                <form className="form-horizontal" onSubmit={handleSubmit}>
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
                            name="username"
                            type="text"
                            label="Username"
                            placeholder="Enter username"
                            value={username}
                            onChange={handleChange}
                            error={errors?.validation?.username}
                            isRequired={true}
                        />
                    </div>

                    <div className="mb-3">
                        <InputField
                            name="firstName"
                            type="text"
                            label="First name"
                            placeholder="Enter first name"
                            value={firstName}
                            onChange={handleChange}
                            error={errors?.validation?.firstName}
                            isRequired={true}
                        />
                    </div>

                    <div className="mb-3">
                        <InputField
                            name="lastName"
                            type="text"
                            label="Last name"
                            placeholder="Enter last name"
                            value={lastName}
                            onChange={handleChange}
                            error={errors?.validation?.lastName}
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
                        <SubmitButton isLoading={isLoading} label="Signup"/>
                    </div>
                </form>
            </div>
        </div>
    );
}

export default SignUp;