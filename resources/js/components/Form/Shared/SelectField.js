import React, { Component } from 'react';
import Select from 'react-select';
import PropTypes from 'prop-types';

class SelectField extends Component {
    constructor(props) {
        super(props);
        this.state = {
            selectedOption: '',
        }
    }
    componentDidMount() {
        if (this.props.field.value) {
            const { options, field } = this.props;

            this.setState({
                selectedOption: this.findOption(options, field.value)
            });
        }
    }
    componentDidUpdate(prevProps) {
        if (prevProps.field.value !== this.props.field.value) {
            const { options, field } = this.props;
            this.setState({
                selectedOption: this.findOption(options, field.value)
            });

        }
    }
    findOption = (options, value) => {
        let option = options.find(option => option.value === value);
        return option ? option : '';
    }
    handleChange = (selected) => {
        const value = selected ? selected.value : '';
        this.setState({
            selectedOption: selected,
        }, () => this.props.form.setFieldValue(this.props.field.name, value))
    };

    render() {
        // console.log(this.props)
        const { field, form, options, isDisabled, isClearable, placeholder } = this.props;
        const { selectedOption } = this.state;
        return (
            <Select
                name={field.name}
                value={selectedOption}
                onChange={this.handleChange}
                onBlur={field.onBlur}
                options={options}
                clearable={false}
                isDisabled={isDisabled}
                isClearable={isClearable}
                className="react-select"
                placeholder={placeholder}
                classNamePrefix="react-select"
                noOptionsMessage={() => "No hay resultados"}
            />
        );
    }
}
SelectField.propTypes = {

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
}

SelectField.defaultProps = {
    options: [],
    placeholder: '',
    isDisabled: false,
    isClearable: true
}

export default SelectField;