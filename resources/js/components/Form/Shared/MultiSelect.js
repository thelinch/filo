import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Select from 'react-select';

class MultiSelect extends Component {
    handleChange = (value) => {
        const { form, field } = this.props;
        form.setFieldValue(field.name, value);
    }
    render() {
        const { field, form, options, isDisabled, isClearable, placeholder } = this.props;
        return (
            <Select 
                isMulti
                name={field.name}
                value={field.value}
                onBlur={field.onBlur}
                onChange={this.handleChange}
                options={options}
                isClearable={isClearable}
                isDisabled={isDisabled}
                className="react-select"
                classNamePrefix="react-select"
                placeholder={placeholder}
                noOptionsMessage={() => 'No hay resultados'}
                // closeOnSelect={false}
                // removeSelected={false}
            />
        );
    }
}

MultiSelect.propTypes = {
    options: PropTypes.arrayOf(PropTypes.shape({
        value: PropTypes.oneOfType([
            PropTypes.number,
            PropTypes.string,
        ]),
        label: PropTypes.string,
    })),
    placeholder: PropTypes.string,
    isDisabled: PropTypes.bool,
    isClearable: PropTypes.bool,
};
MultiSelect.defaultProps = {
    options: [],
    placeholder: '',
    isDisabled: false,
    isClearable: true,
}
export default MultiSelect;