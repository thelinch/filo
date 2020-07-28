import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { Check } from '@material-ui/icons';
// import classNames from 'classnames';

class MultiCheckBox extends Component {
    // handleChange = (e) =>{
    //     const { value, checked } = e.target;
    //     const{field, form} = this.props;
    //     const newValue = [...field.value];
    //     if (checked) {
    //       newValue.push(value);
    //     } else {
    //       newValue.splice(newValue.indexOf(value), 1);
    //     }
    //     form.setFieldValue(field.name,newValue);
    // }
    handleChange = (e) =>{
        const { value } = e.target;
        const{field, form} = this.props;
        
        const newValue = field.value.includes(value) ?
                            field.value.filter(item=>item !== value)
                            : [...field.value, value];
        form.setFieldValue(field.name,newValue);
    }
    render() {
        const {field, options, position } = this.props;
        return (
            <>
                {
                    options.map(({value, label}, i) =>{

                        return (
                            <div className="form-group" key={value}>
                              <div className="form-group-field">
                              <label className={`checkbox-button ${position ? ` checkbox-button-${position}` : ''}`}>
                                  <input
                                    className="checkbox-button-checkbox"
                                    type="checkbox"
                                    id={`${field.name}[${i}]`}
                                    name={`${field.name}[${i}]`}
                                    // checked={field.value.indexOf(value) !== -1}
                                    checked={field.value.includes(value)}
                                    onChange={this.handleChange}
                                    value={value}
                                  />
                                  <span className={`checkbox-button-checkbox-custom`}>
                                    <Check fontSize="small" />
                                  </span>
                                  <span className="checkbox-button-label">
                                    {label}
                                  </span>
                                </label>
                              </div>
                            </div>)
                    })
                }  
            </>
        );
    }
}

MultiCheckBox.propTypes = {
    options: PropTypes.arrayOf(PropTypes.shape({
        value: PropTypes.oneOfType([
            PropTypes.number,
            PropTypes.string,
        ]),
        label: PropTypes.string,
    })),
    position: PropTypes.string,
};
MultiCheckBox.defaultProps = {
    options: [],
    position: ''
}
export default MultiCheckBox;