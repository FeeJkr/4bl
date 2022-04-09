import React from "react";
import Input from "../../../components/Fields/Form/Input";
import {fields, labels, placeholders} from "../../../helpers/forms/invoices/addresses";

const Form = ({onChange, errors, object}) => {
    return (
        <>
            <Input
                type="text"
                name={fields.street}
                label={labels[fields.street]}
                placeholder={placeholders[fields.street]}
                onChange={onChange}
                error={errors[fields.street]}
                defaultValue={object[fields.street]}
            />
            <Input
                type="text"
                name={fields.city}
                label={labels[fields.city]}
                placeholder={placeholders[fields.city]}
                onChange={onChange}
                error={errors[fields.city]}
                defaultValue={object[fields.city]}
            />
            <Input
                type="text"
                name={fields.zipCode}
                label={labels[fields.zipCode]}
                placeholder={placeholders[fields.zipCode]}
                onChange={onChange}
                error={errors[fields.zipCode]}
                defaultValue={object[fields.zipCode]}
            />
        </>
    );
}

export {Form};