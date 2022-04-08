import React from "react";
import ReactSelect from "react-select";
import ErrorMessage from "./ErrorMessage";

const customStyles = {
    control: (styles, { data, isDisabled, isFocused, isSelected }) => {
        return {
            ...styles,
            backgroundColor: 'white',
            borderColor: isFocused ? 'rgb(42, 48, 66)' : 'hsl(0, 0%, 80%)',
            boxShadow: 'none',
            minHeight: '30px',
            ':focus': {
                ...styles[':focus'],
                borderColor: 'rgb(42, 48, 66)',
                boxShadow: 'rgb(18 38 63 / 3%) 0 0.75rem 1.5rem',
            },
            ':hover': {
                ...styles[':hover'],
                borderColor: 'rgb(42, 48, 66)',
            }
        };
    },
    dropdownIndicator: (styles) => ({
        ...styles,
        padding: 5.75,
    }),
    clearIndicator: (styles) => ({
        ...styles,
        padding: 5.75,
    }),
    valueContainer: (styles) => ({
        ...styles,
        padding: '0px 6px',
    }),
    option: (styles, { data, isDisabled, isFocused, isSelected }) => {
        return {...styles};
    },
    container: (styles) => {
        return {
            ...styles,
        };
    },
    input: (styles) => ({
        ...styles,
        margin: 0,
        padding: 0,
    }),
    placeholder: (styles) => ({ ...styles}),
    singleValue: (styles, { data }) => ({ ...styles }),
};

export default function Select(props) {
    const {
        name,
        label,
        options,
        onChange,
        error,
        defaultValue,
    } = props;

    return (
        <div className="mb-3 form-group">
            <label htmlFor={name} style={{marginBottom: '.5rem', fontWeight: 500}}>{label}</label>
            <ReactSelect
                name={name}
                options={options}
                onChange={onChange}
                defaultValue={options.find(option => option.value === defaultValue)}
                styles={customStyles}
            />
            {error && <ErrorMessage text={error.message}/>}
        </div>
    );
}
