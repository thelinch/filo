import React, { Component } from 'react';
import PropTypes from 'prop-types';
import SelectComponent from 'react-select';
class Select extends Component {
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
        const { field, options, isDisabled, placeholder } = this.props;
        const { selectedOption } = this.state;
        return (
            <SelectComponent
                name={field.name}
                styles={{ zIndex: "100000" }}
                value={selectedOption}
                onChange={this.handleChange}
                onBlur={field.onBlur}
                options={options}
                clearable={false}
                isDisabled={isDisabled}
                isClearable={false}
                className="react-select"
                placeholder={placeholder}
                classNamePrefix="react-select"
                isSearchable={true}
                noOptionsMessage={() => "No hay resultados"}

            />
            // <select
            //     className="select"
            //     name={field.name}
            //     value={field.value}
            //     onChange={this.handleChange}
            //     onBlur={field.onBlur}
            // >
            //     <option value="">{placeholder}</option>
            //     {
            //         options.map((item, i) =>
            //             <option value={item.value} key={i}>{item.label}</option>
            //         )
            //     }
            // </select>
        );
    }
}

Select.propTypes = {
    options: PropTypes.arrayOf(PropTypes.shape({
        value: PropTypes.oneOfType([
            PropTypes.number,
            PropTypes.string,
        ]),
        label: PropTypes.string,
    })),
    placeholder: PropTypes.string,
    isDisabled: PropTypes.bool,
};
Select.defaultProps = {
    options: [],
    placeholder: 'Seleccionar',
    isDisabled: false
}
export default Select;