import React from 'react';
import Loader from 'react-loader-spinner';

const Spinner = ({ type = "Rings", ...props }) => (
    <div className="overlay-spinner">
        <div className="spinner-content">
            <Loader
                type={type}
                // color={'#004889'}
                color={'#138035'}
                height={100}
                width={100}
                {...props}
            />
        </div>
    </div>
);

export default Spinner;